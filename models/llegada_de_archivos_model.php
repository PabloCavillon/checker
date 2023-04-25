<?php
    class Llegada_de_archivos_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_archivos($fecha){
            $query = $this->db->connect()->prepare('CALL ARCHIVOS_ESPERADOS_EN_FECHA(:fecha)');
            $query->execute(['fecha' => $fecha]);

            $items = [];
            while ($row = $query->fetch()){
                $item = [
                    'banco' => $row['id_banco'],
                    'archivo' => $row['nombre_archivo'],
                    'hora' => $row['hora_esperada'],
                    'llegada' => $row['esta_en_vnet'],
                    'reportar_a' => $row['reportar_a']
                ];

                array_push($items, $item);
            }

            return $items;
        }
    }
?>