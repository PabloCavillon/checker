<?php
    class Peso_de_archivos_model extends model{
        function __construct(){
            parent::__construct();
        }

        function get_pesos_de_archivos($periodo, $cartera){
            $query = $this->db->connect()->prepare('CALL PESO_ARCHIVOS_A_COMPARAR(:periodo, :cartera, :tipo);');
            $query->execute([
                'periodo' => $periodo,
                'cartera' => $cartera,
                'tipo'    => 'L'
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'banco' => $row['banco'],
                    'cartera' => $row['cartera_1'],
                    'archivo_1' => $row['archivo_1'],
                    'periodo_1' => $row['periodo_1'],
                    'peso_1' => $row['peso_1'],
                    'archivo_2' => $row['archivo_2'],
                    'periodo_2' => $row['periodo_2'],
                    'peso_2' => $row['peso_2'],
                    'relacion' => $row['relacion_peso'],
                    'tipo' => 'L'
                ];
                array_push($items, $item);
            }

            $query = $this->db->connect()->prepare('CALL PESO_ARCHIVOS_A_COMPARAR(:periodo, :cartera, :tipo);');
            $query->execute([
                'periodo' => $periodo,
                'cartera' => $cartera,
                'tipo'    => 'P'
            ]);

            while($row = $query->fetch()){
                $item = [
                    'banco' => $row['banco'],
                    'cartera' => $row['cartera_1'],
                    'archivo_1' => $row['archivo_1'],
                    'periodo_1' => $row['periodo_1'],
                    'peso_1' => $row['peso_1'],
                    'archivo_2' => $row['archivo_2'],
                    'periodo_2' => $row['periodo_2'],
                    'peso_2' => $row['peso_2'],
                    'relacion' => $row['relacion_peso'],
                    'tipo' => 'P'
                ];
                array_push($items, $item);
            }

            return $items;
        }

        function get_carteras(){
            $query = $this->db->connect()->prepare(
                'SELECT 
                    cartera 
                FROM 
                    view_bancos_x_cartera 
                GROUP BY 
                    cartera
                ORDER BY
                    cartera ASC;'
            );
            $query->execute();

            $items = [];
            while($row = $query->fetch()){
                array_push($items, $row['cartera']);
            }
            
            return $items;
        }
    } 
?>