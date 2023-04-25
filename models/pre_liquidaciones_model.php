<?php
    include_once 'models/class/liquidacion.php'; 

    class Pre_liquidaciones_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_carteras_con_pendientes($usuario){
            $carteras = [];
            try{
                if ($usuario == ""){
                    $query = $this->db->connect()->prepare("CALL get_carteras_de_preliquidaciones_pendientes();");
                    $query->execute();
                } else {
                    $query = $this->db->connect()->prepare("CALL get_carteras_de_preliquidaciones_pendientes_asignado(:usuario);");
                    $query->execute(['usuario' => $usuario]);
                }

                while ($row = $query->fetch()){
                    $cartera = $row['cartera'];
                    array_push($carteras, $cartera);
                }
                return $carteras;
            }catch (PDOException $e) {
                return [];
            } 
        }

        function get_preliquidaciones_pendientes($usuario){
            $pre_liquidaciones = [];
            try{
                if($usuario == ""){
                    $query = $this->db->connect()->prepare("CALL get_preliquidaciones_pendientes();");
                    $query->execute();
                } else {
                    $query = $this->db->connect()->prepare("CALL get_preliquidaciones_pendientes_asignadas(:usuario);");
                    $query->execute(['usuario' => $usuario]);
                }

                while ($row = $query->fetch()){
                    $pre_liquidacion = new Liquidacion(); 
                    
                    $pre_liquidacion->id = $row['id'];
                    $pre_liquidacion->tarea = $row['tipo_de_liquidacion'];
                    $pre_liquidacion->usuario = $row['usuario'];
                    $pre_liquidacion->nombre_usuario = $row['nombre_usuario'];
                    $pre_liquidacion->apellido_usuario = $row['apellido_usuario'];
                    $pre_liquidacion->apodo = $row['apodo'];
                    $pre_liquidacion->interno = $row['interno'];
                    $pre_liquidacion->banco = $row['banco'];
                    $pre_liquidacion->estado = $row['estado'];
                    $pre_liquidacion->cartera = $row['cartera'];
                    $pre_liquidacion->tipo_cartera = $row['tipo_cartera'];
                    $pre_liquidacion->comentario = $row['comentario'];
                    $pre_liquidacion->fecha = $row['fecha'];

                    array_push($pre_liquidaciones, $pre_liquidacion);
                }
                return $pre_liquidaciones;
            } catch (PDOExcetion $e){
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