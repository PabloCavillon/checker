<?php
    include_once 'models/class/liquidacion.php'; 

    class Liquidaciones_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_fechas_con_pendientes(){
            $fechas = [];
            try{
                $query = $this->db->connect()->prepare("CALL get_fechas_de_liquidaciones_pendientes();");
                $query->execute();

                while ($row = $query->fetch()){
                    $fecha = [
                        'fecha' => $row['fecha'],
                        'cantidad' => $row['cantidad']    
                    ];

                    array_push($fechas, $fecha);
                }
                return $fechas;
            }catch (PDOException $e) {
                return [];
            } 
        }

        function get_liquidaciones_pendientes_por_fecha($fecha){
            $liquidaciones = [];
            try{
                $query = $this->db->connect()->prepare("CALL get_liquidaciones_pendientes_por_fecha(:fecha);");
                $query->execute(['fecha' => $fecha]);

                while ($row = $query->fetch()){
                    $liquidacion = new Liquidacion();
                    
                    $liquidacion->id = $row['id'];
                    $liquidacion->tarea = $row['tipo_de_liquidacion'];
                    $liquidacion->usuario = $row['usuario'];
                    $liquidacion->nombre_usuario = $row['nombre_usuario'];
                    $liquidacion->apellido_usuario = $row['apellido_usuario'];
                    $liquidacion->apodo = $row['apodo'];
                    $liquidacion->interno = $row['interno'];
                    $liquidacion->banco = $row['banco'];
                    $liquidacion->estado = $row['estado'];
                    $liquidacion->cartera = $row['cartera'];
                    $liquidacion->tipo_cartera = $row['tipo_cartera'];
                    $liquidacion->comentario = $row['comentario'];
                    $liquidacion->fecha = $row['fecha'];

                    array_push($liquidaciones, $liquidacion);
                }

                return $liquidaciones;
            } catch (PDOExcetion $e){
                return [];
            }
        }

        function get_liquidaciones_pendientes_asignadas($fecha, $asignado){
            $liquidaciones = [];
            try{
                $query = $this->db->connect()->prepare("CALL get_mis_liquidaciones_asignadas_pendientes(:asignado, :fecha);");
                $query->execute([ 'asignado' => $asignado, 'fecha' => $fecha]);

                while ($row = $query->fetch()){
                    $liquidacion = new Liquidacion();
                    
                    $liquidacion->id = $row['id'];
                    $liquidacion->tarea = $row['tipo_de_liquidacion'];
                    $liquidacion->usuario = $row['usuario'];
                    $liquidacion->nombre_usuario = $row['nombre_usuario'];
                    $liquidacion->apellido_usuario = $row['apellido_usuario'];
                    $liquidacion->apodo = $row['apodo'];
                    $liquidacion->interno = $row['interno'];
                    $liquidacion->banco = $row['banco'];
                    $liquidacion->estado = $row['estado'];
                    $liquidacion->cartera = $row['cartera'];
                    $liquidacion->tipo_cartera = $row['tipo_cartera'];
                    $liquidacion->comentario = $row['comentario'];
                    $liquidacion->fecha = $row['fecha'];

                    array_push($liquidaciones, $liquidacion);
                }
                return $liquidaciones;
            } catch (PDOException $e) {
                return [];
            }
        }
        
        function set_ok($id_tarea, $comentario){
            $query = $this->db->connect()->prepare("CALL CERRAR_LIQUIDACION(:id_usuario, :id_tarea, :estado, :comentario);");
            $query->execute([
                'id_usuario' => $_SESSION['id'],
                'id_tarea' => $id_tarea,
                'estado' => 'ok',
                'comentario' => $comentario]);
            return true;
        }

        function set_error($id_tarea, $comentario){
            $query = $this->db->connect()->prepare("CALL CERRAR_LIQUIDACION(:id_usuario, :id_tarea, :estado, :comentario);");
            echo ($_SESSION['id'] . "  " . $id_tarea . "  error  " . $comentario);
            $query->execute([
                'id_usuario' => $_SESSION['id'], 
                'id_tarea' => $id_tarea,
                'estado' => 'error',
                'comentario' => $comentario]);
            return true;
        }

        function set_mine($id_liquidacion){
            $query = $this->db->connect()->prepare("CALL ASIGNAR_LIQUI_PRELI(:id_usuario, :id_liquidacion);");
            $query->execute([
                'id_usuario' => $_SESSION['id'],
                'id_liquidacion' => $id_liquidacion
            ]);
            return true;
        }
    }
?>