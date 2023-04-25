<?php
    class Conciliacion_model extends model{
        function __construct(){
            parent::__construct();
        }

        function get_conciliacion_visa($fecha){
            $query = $this->db->connect()->prepare("
                SELECT 
                    total_028, 
                    total_025A, 
                    id_banco as banco, 
                    namefile_025A, 
                    movimientos_financieros , 
                    movimientos_atm, 
                    movimientos_merchandise, 
                    movimientos_cco, 
                    namefile_028, 
                    movimientos_financieros_ml, 
                    movimientos_OnUs_ml,
                    movimientos_financieros_usd,
                    movimientos_OnUs_usd,
                    rechazos
                FROM 
                    " + constant('DB') + ".view_conciliacion_visa
                Where fecha_025A = :fecha
            ");
            $query->execute(['fecha' => $fecha]);

            $items = [];
            while ($row = $query->fetch()) {
                $item = [
                    'banco' => $row['banco'], 
                    'total_028' => $row['total_028'],
                    'total_025A' => $row['total_025A'],
                    'namefile_025A' => $row['namefile_025A'],
                    'movimientos_financieros' => $row['movimientos_financieros'],
                    'movimientos_atm' => $row['movimientos_atm'],
                    'movimientos_merchandise' => $row['movimientos_merchandise'],
                    'movimientos_contracargo' => $row['movimientos_cco'],
                    'namefile_028' => $row['namefile_028'],
                    'movimientos_onus_ml' => $row['movimientos_OnUs_ml'],
                    'movimientos_noonus_ml' => $row['movimientos_financieros_ml'],
                    'movimientos_onus_usd' => $row['movimientos_OnUs_usd'],
                    'movimientos_noonus_usd' => $row['movimientos_financieros_usd'],
                    'rechazos' => $row['rechazos']
                ];
                array_push($items, $item);
            }
            
            return $items;
        }

        function get_max_min_fechas_visa()
        {
            $query = $this->db->connect()->prepare("SELECT max(fecha_025A) as max, min(fecha_025A) as min FROM " + constant('DB') + ".view_conciliacion_visa");
            $query->execute();

            $items = [];
            while($row = $query->fetch()) {
                $items = [
                    'max' => $row['max'],
                    'min' => $row['min']
                ];
            }
            return $items;
        }
    } 
?>