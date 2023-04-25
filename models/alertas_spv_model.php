<?php 
    class Alertas_spv_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_alertas($fecha){
            $query = $this->db->connect()->prepare('CALL ALERTAS_SPV(:fecha)');
            $query->execute(['fecha' => $fecha]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'id' => $row['id'],
                    'banco' => $row['id_banco'],
                    'alerta' => $row['nombre_archivo'],
                    'hora' => $row['hora']
                ];
                array_push($items,$item);
            }

            return $items;
        }
    }
?>