<?php 
    class rechazos_zcga010_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_bancos(){
            $query = $this->db->connect()->prepare('CALL GET_BANCOS_ADQUIRENTES()');
            $query->execute();
            
            $bancos = [];
            while ($row = $query->fetch()){
                array_push($bancos, $row['banco']);
            }

            return $bancos;
        }
        
        function get_rechazos_zgea500($fecha){
            $query = $this->db->connect()->prepare('select * 
                                                    from 
                                                    ' + constant('DB') + '.rechazos_del_zgea500 
                                                    where 
                                                        :fecha between fecha and fecha_ultimo_reingreso');

            $query->execute([
                'fecha' => $fecha
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'banco' => $row['id_banco'],
                    'fecha' => $row['fecha'],
                    'tarjeta' => $row['numero_tarjeta'],
                    'transaccion' => $row['codigo_unico_de_transaccion'],
                    'moneda' => $row['moneda_original_transaccion'],
                    'importe' => $row['importe_original_transaccion'],
                    'pdv' => $row['numero_punto_de_venta'],
                ];
                array_push($items, $item);
            }
            return $items;
        }

        function get_rechazos_zcga010($fecha){
            $query = $this->db->connect()->prepare('CALL RECHAZOS_ZCGA010(:fecha);');
            $query->execute([
                'fecha' => $fecha
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'banco' => $row['id_banco'],
                    'codop' => $row['codop'],
                    'nro_tarjeta' => $row['numero_tarjeta'],
                    'pdv' => $row['numero_punto_de_venta'],
                    'fecha' => $row['fecha_original_del_movimiento'],
                    'nro_referencia' => $row['numero_referencia'],
                    'moneda' => $row['moneda'],
                    'importe' => $row['importe'],
                    'descripcion' => $row['descripcion']
                ];
                array_push($items, $item);
            }
            return $items;
        }

        function get_tipos_de_rechazos($fecha){
            $query = $this->db->connect()->prepare('SELECT 
                                                        descripcion, count(*) AS cantidad, id_banco 
                                                    FROM 
                                                        ' + constant('DB') + '.view_rechazos_del_zcga010
                                                    WHERE 
                                                        fecha = :fecha
                                                    GROUP BY 
                                                        descripcion, id_banco
                                                    ORDER BY 
	                                                    id_banco');
            $query->execute([
                'fecha' => $fecha
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'banco' => $row['id_banco'],
                    'descripcion' => $row['descripcion'],
                    'cantidad' => $row['cantidad'] 
                ];
                array_push($items, $item);
            }
            return $items;
        }
    }
?>