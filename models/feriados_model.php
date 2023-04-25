<?php 
    class Feriados_model extends model{
        function __construct(){
            parent::__construct();
        }

        function get_feriados($year){
            $query = $this->db->connect()->prepare("CALL get_feriados_x_usuario(:year)");
            $query->execute([
                'year' => $year 
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'id_feriado' =>     $row['id'],
                    'dia' =>            $row['dia'],
                    'mes' =>            $row['mes'],
                    'year' =>           $row['year'],
                    'descripcion' =>    $row['descripcion'],
                    'apodo' =>          $row['apodo']
                ];
                array_push($items, $item);
            }
            return $items;
        } 

        function set_feriado($id_feriado, $id_usuario){
            $query = $this->db->connect()->prepare("CALL ASIGNAR_FERIADO(:id_usuario, :id_feriado);");
            $query->execute([
                'id_usuario' => $id_usuario,
                'id_feriado' => $id_feriado]);
             
            return true;
        }

        function unset_feriado($id_feriado, $id_usuario){
            $query = $this->db->connect()->prepare("CALL DESASIGNAR_FERIADO(:id_usuario, :id_feriado);");
            $query->execute([
                'id_usuario' => $id_usuario, 
                'id_feriado' => $id_feriado
            ]);
            return true;
        }

        function agregar_feriado($feriado, $dia, $mes, $year){
            $query = $this->db->connect()->prepare("CALL AGREGAR_FERIADO(:dia, :mes, :year, :feriado)");
            $query->execute([
                'dia'     => $dia,
                'mes'     => $mes,
                'year'    => $year,
                'feriado' => $feriado
            ]);
        }
         
        function verificar_fecha($dia, $mes, $year){
            $query = $this->db->connect()->prepare("SELECT id FROM  " + constant('DB') + ".feriados WHERE dia = :dia and mes = :mes and year = :year");
            $query->execute([
                'dia' => $dia,
                'mes' => $mes,
                'year' => $year
            ]);
            
            $cant = 0;
            while ($row = $query->fetch()){
                $cant++;
            }
            return $cant;
        }

        function eliminar_feriado($id_feriado){
            $query = $this->db->connect()->prepare("CALL ELIMINAR_FERIADO(:id)");
            $query->execute([
                'id' => $id_feriado
            ]);
        }
    }
?>