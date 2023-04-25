<?php
    class Estadisticas_Model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_estadisticas_tareas($periodo){
            $query = $this->db->connect()->prepare('SELECT 
                                                        apellido_usuario as apellido, 
                                                        COUNT(*) as cantidad
                                                    FROM
                                                        checker.view_log_tareas
                                                    WHERE 
                                                        periodo = :periodo
                                                    GROUP BY usuario
                                                    ORDER BY cantidad desc;');
            $query->execute(['periodo' => $periodo]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'apellido' => $row['apellido'],
                    'cantidad' => $row['cantidad']
                ];
                array_push($items, $item);
            }

            return $items;
        }

        function get_estadisticas_tareas_por_estado($periodo, $estado){
            $query = $this->db->connect()->prepare('SELECT 
                                                        apellido_usuario as apellido, 
                                                        COUNT(*) as cantidad
                                                    FROM
                                                        ' + constant('DB') + '.view_log_tareas
                                                    WHERE 
                                                        periodo = :periodo 
                                                        AND estado = :estado
                                                    GROUP BY usuario
                                                    ORDER BY cantidad desc;');
            $query->execute([
                'periodo' => $periodo,
                'estado' => $estado
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'apellido' => $row['apellido'],
                    'cantidad' => $row['cantidad']
                ];
                array_push($items, $item);
            }

            return $items;
        }

        function get_estadisticas_liquis($periodo){
            $query = $this->db->connect()->prepare('SELECT 
                                                        apellido_usuario as apellido, 
                                                        COUNT(*) as cantidad
                                                    FROM
                                                        ' + constant('DB') + '.view_log_liquidaciones
                                                    WHERE 
                                                        periodo = :periodo
                                                    GROUP BY usuario
                                                    ORDER BY cantidad desc;');
            $query->execute(['periodo' => $periodo]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'apellido' => $row['apellido'],
                    'cantidad' => $row['cantidad']
                ];
                array_push($items, $item);
            }

            return $items;
        }

        function get_estadisticas_liquis_por_estado($periodo, $estado){
            $query = $this->db->connect()->prepare('SELECT 
                                                        apellido_usuario as apellido, 
                                                        COUNT(*) as cantidad
                                                    FROM
                                                        ' + constant('DB') + '.view_log_liquidaciones
                                                    WHERE 
                                                        periodo = :periodo 
                                                        AND estado = :estado
                                                    GROUP BY usuario
                                                    ORDER BY cantidad desc;');
            $query->execute([
                'periodo' => $periodo,
                'estado' => $estado
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'apellido' => $row['apellido'],
                    'cantidad' => $row['cantidad']
                ];
                array_push($items, $item);
            }

            return $items;
        }
    }
?>