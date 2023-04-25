<?php
    class Adquirencia_model extends Model{
        function __construct(){
            parent::__construct();
        }
        
        
        function get_adquirencia($fecha){
            $items = [];
            $query = $this->db->connect()->prepare("CALL indicadores_liquidacion_adquirencia(:fecha);");
            $query->execute([
                'fecha' => $fecha
            ]);
            
            while($row = $query->fetch()){
                $items[$row['Banco']]['pendientes'] = $row['Pendientes'];
                $items[$row['Banco']]['totales'] = $row['Totales'];
            }

            return $items;
        }
    }
?>