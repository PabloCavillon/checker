<?php 
    class liquidacion_inmediata_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_inmediata_resumen($fecha){
            $query = $this->db->connect()->prepare('CALL LIQUIDACION_INMEDIATA_RESUMEN(:fecha)');
            $query->execute(['fecha' => $fecha]);

            $items = [];
            while($row =$query->fetch()){
                $item = [
                    'banco' => $row['cod_banco'], 
                    'zlei001' => $row['ZLEI001'], 
                    'tc40' => $row['TC40'], 
                    'vnet' => $row['VNET'], 
                    'rechazos' => $row['Rechazos']
                ];

                array_push($items, $item); 
            }

            return $items;
        }

        function get_bancos(){
            $query = $this->db->connect()->prepare('CALL GET_BANCOS_INMEDIATA()');
            $query->execute();
            
            $bancos = [];
            while ($row = $query->fetch()){
                array_push($bancos, $row['banco']);
            }

            return $bancos;
        }
    
        function get_zlei001($fecha, $cod_banco){
            $items = [];

            $query = $this->db->connect()->prepare("CALL LIQUIDACION_INMEDIATA_ZLEA002(:fecha, :cod_banco);");
            $query->execute([
                'fecha' => $fecha,
                'cod_banco' => $cod_banco
            ]);

            while ($row = $query->fetch()){
                array_push($items, $row['ZLEA002']);
            }

            $query = $this->db->connect()->prepare("CALL LIQUIDACION_INMEDIATA_ZLEI001(:fecha, :cod_banco);");
            $query->execute([
                'fecha' => $fecha,
                'cod_banco' => $cod_banco
            ]);

            while ($row = $query->fetch()){
                array_push($items, $row['ZLEI001']);
            }

            return $items;
        }

        function get_tc40($fecha, $cod_banco){
            $query = $this->db->connect()->prepare('CALL LIQUIDACION_INMEDIATA_TC40(:fecha, :cod_banco)');
            $query->execute([
                'fecha' => $fecha,
                'cod_banco' => $cod_banco
            ]);

            $items = [];
            while ($row = $query->fetch()){
                $item = [
                    'tc40' => $row['TC40'],
                ];
                array_push($items, $item);
            }

            return $items;
        }

        function get_vnet($fecha, $cod_banco){
            $query = $this->db->connect()->prepare('call liquidacion_inmediata_vnet(:fecha, :cod_banco);');
            $query->execute([
                'fecha' => $fecha,
                'cod_banco' => $cod_banco
            ]);

            $items = [];
            while($row = $query->fetch()){
                array_push($items, $row['VNET']);
            }

            return $items;
        }

        function get_rechazos($fecha, $cod_banco){
            $query = $this->db->connect()->prepare('CALL MOSTRAR_RECHAZOS_ZLEI001(:fecha, :cod_banco);');
            $query->execute([
                'fecha' => $fecha,
                'cod_banco' => $cod_banco
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'archivo' => $row['archivo'],
                    'codop' => $row['codop'],
                    'nro_tarjeta' => $row['numero_tarjeta'],
                    'pdv' => $row['numero_punto_de_venta'],
                    'importe' => $row['importe'],
                    'descripcion' => $row['descripcion']
                ];
                array_push($items, $item);
            }
            return $items;
        }

        function get_tipos_rechazos($fecha, $cod_banco, $items){
            $query = $this->db->connect()->prepare('CALL MOSTRAR_RECHAZOS_ZLEI001(:fecha, :cod_banco);');
            $query->execute([
                'fecha' => $fecha,
                'cod_banco' => $cod_banco
            ]);
            
            while($row = $query->fetch()){
                if (isset($items[$row['descripcion']])){
                    $items[$row['descripcion']]['cantidad'] += 1;
                } else {
                    $items[$row['descripcion']] = ['descripcion' => $row['descripcion'] , 'cantidad' => 1];
                }
            }
            return $items;
        }

        function get_rechazos_por_lote($fecha){
            $query = $this->db->connect()->prepare('call mostrar_rechazos_por_lote_del_zlei001(:fecha)');
            $query->execute([
                'fecha' => $fecha
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [   
                    'id_banco'      => $row['banco'],
                    'archivo'       => $row['nombre_archivo'],
                    'descripcion'   => $row['descripcion'],
                    'cantidad'      => $row['cantidad_de_rechazos']
                ];
                array_push($items, $item);
            }
            return $items;
        }

        function get_alertar_PCCGCOE(){
            $query = $this->db->connect()->prepare('call alerta_PCCGCOE()');
            $query->execute([]);

            $alerta = 0;
            while ($row = $query->fetch()) {
                $alerta = $row['@alertar'];
            }

            return $alerta;
        }

        function get_ultima_hora() {
            $query = $this->db->connect()->prepare('SELECT hora FROM  ' + constant('DB') + '.archivos_de_pccgcoe ORDER BY id DESC LIMIT 1;');
            $query->execute([]);

            $item;
            while ($row = $query->fetch()) {
                $item = $row['hora'];
            }

            return $item;
        }
    }
?>