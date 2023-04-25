<?php
    class Archivos_diarios_model extends Model {
        function __construct(){
            parent::__construct();
        }

        function get_archivos_diarios($fecha){
            $query = $this->db->connect()->prepare("CALL ARCHIVOS_DIARIOS('$fecha')");
            $query->execute();

            $archivos = []; 
            while($row = $query->fetch()){
                $archivo = [
                    'nombre' => $row['nombre_archivo'],
                    'primero' => $row['primero'],
                    'ultimo' => $row['ultimo'],
                    'cantidad' => $row['Cantidad']
                ];
                array_push($archivos, $archivo);
            }
            return ($archivos);
        }

        function get_detalle($tipo_archivo, $fecha){

            $query = $this->db->connect()->prepare("SELECT id_banco, nombre_archivo, hora
                                                    FROM " + constant('DB') + ".archivos_de_vnet
                                                    WHERE fecha = '$fecha'
                                                        AND nombre_archivo LIKE '%$tipo_archivo%zip'
                                                    ORDER BY hora, id_banco;");

            if ($tipo_archivo == "DATACARD"){
                $ayer = date("Y-m-d", strtotime("-1 day", strtotime( $fecha ))); 
                $query = $this->db->connect()->prepare("SELECT id_banco, nombre_archivo, hora
                                                        FROM " + constant('DB') + ".archivos_de_vnet
                                                        WHERE fecha = '$ayer'
                                                            AND nombre_archivo LIKE '%datacard%'
                                                            AND hora > '21:00:00'
                                                        ORDER BY hora, id_banco;");
            }

            $query->execute();

            $data = [];
            while ($row = $query->fetch()){
                $d = [
                    'banco' => $row['id_banco'],
                    'archivo' => $row['nombre_archivo'],
                    'hora' => $row['hora']
                ];
                array_push($data, $d);
            }
            return($data);
        }

        function get_data_grafico($periodo) {

             $query = $this->db->connect()->prepare("SELECT dayofyear(fecha) as juliano, date_format(CONCAT(fecha, ' ', hora), '%Y-%m-%d %h:%i') as fecha
                                                     FROM " + constant('DB') + ".archivos_de_vnet
                                                     WHERE periodo >= :periodo AND 
                                                     (nombre_archivo like '%posicion%' or
                                                     nombre_archivo like '%pcrendir%' or
                                                     nombre_archivo like '%usudes%' or
                                                     nombre_archivo like '%tardes%')
                                                     group by juliano");

            $query->execute(['periodo' => $periodo]);

            $data = []; 
            while($row = $query->fetch()){
                $d = [
                    'juliano' => $row['juliano'],
                    'fecha' => $row['fecha']
                ];
                array_push($data, $d);
            }
            return ($data);
        }
    }

?>