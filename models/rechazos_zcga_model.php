<?php 
    class rechazos_zcga_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_rechazos($fecha){
            $query = $this->db->connect()->prepare("
                SELECT 
                    banco, descripcion, COUNT(*) AS cantidad_de_rechazos, filename
                FROM
                " + constant('DB') + ".rechazos_zcga
                WHERE
                    fecha = :fecha
                GROUP BY banco , descripcion , filename
                ORDER BY banco , filename , descripcion;");

            $query->execute([
                'fecha' => $fecha
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'banco' => $row['banco'],
                    'descripcion' => $row['descripcion'],
                    'cantidad' => $row['cantidad_de_rechazos'],
                    'zcga' => substr($row['filename'], 4, 7)
                ];
                array_push($items, $item);
            }
            return $items;
        }
    }
?>