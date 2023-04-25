<?php
    class Adquirencia_new_model extends Model{
        function __construct(){
            parent::__construct();
        }
        
        function get_adquirencia($fecha, $banco){
            $items = [];
            $query = $this->db->connect()->prepare("CALL indicadores_liquidacion_adquirencia_2(:banco, :fecha);");
            $query->execute([
                'fecha' => $fecha,
                'banco' => $banco
            ]);
            while($row = $query->fetch()){
                $items['pendientes'] = $row['Pendientes'];
                $items['totales'] = $row['Totales'];
                $items['fecha'] = $fecha;
            }
            return $items;
        }
    }
?>