<?php

    include_once 'models/class/tarea.php';

    class Diarias_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_fechas_con_pendientes(){
            $fechas = [];
            try{ 
                $query = $this->db->connect()->prepare("CALL get_fechas_de_tareas_pendientes();");
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

        function get_grupos_tareas(){
            $grupos = [];
            try{
                $query = $this->db->connect()->prepare("CALL get_grupos_tareas();");
                $query->execute();

                while ($row = $query->fetch()){
                    array_push($grupos, $row['nombre']);
                }
                return $grupos;
            }catch (PDOException $e) {
                return [];
            } 
        }

        function get_tareas_pendientes_por_fecha($fecha){
            $tareas = [];
            try{
                $query = $this->db->connect()->prepare("CALL get_tareas_pendientes_por_fecha(:fecha);");
                $query->execute(['fecha' => $fecha]);

                while($row = $query->fetch()){
                    $tarea = new Tarea();

                    $tarea->id = $row['id'];
                    $tarea->tarea = $row['tarea'];
                    $tarea->apodo = $row['apodo'];
                    $tarea->nombre_usuario = $row['nombre_usuario'];
                    $tarea->apellido_usuario = $row['apellido_usuario'];
                    $tarea->usuario = $row['usuario'];
                    $tarea->interno = $row['interno'];
                    $tarea->estado = $row['estado'];
                    $tarea->comentario = $row['comentario'];
                    $tarea->fecha_creado = $row['fecha_creado'];
                    $tarea->hora_tarea = $row['hora_tarea'];
                    $tarea->fecha_cerrado = $row['fecha_cerrado'];
                    $tarea->hora_cerrado = $row['hora_cerrado'];
                    $tarea->vista_en_checker = $row['vista_en_checker'];

                    array_push($tareas, $tarea);
                }   
                return $tareas;
            } catch (PDOException $e) {
                return [];
            } 
        }

        function get_tareas_pendientes_asignadas($fecha, $asignado){
            $tareas = [];
            try{
                $query = $this->db->connect()->prepare("CALL get_mis_tareas_asignadas_pendientes(:asignado, :fecha);");
                $query->execute([ 'asignado' => $asignado, 'fecha' => $fecha]);

                while($row = $query->fetch()){
                    $tarea = new Tarea();

                    $tarea->id = $row['id'];
                    $tarea->tarea = $row['tarea'];
                    $tarea->apodo = $row['apodo'];
                    $tarea->nombre_usuario = $row['nombre_usuario'];
                    $tarea->apellido_usuario = $row['apellido_usuario'];
                    $tarea->usuario = $row['usuario'];
                    $tarea->interno = $row['interno'];
                    $tarea->estado = $row['estado'];
                    $tarea->comentario = $row['comentario'];
                    $tarea->fecha_creado = $row['fecha_creado'];
                    $tarea->hora_tarea = $row['hora_tarea'];
                    $tarea->fecha_cerrado = $row['fecha_cerrado'];
                    $tarea->hora_cerrado = $row['hora_cerrado'];
                    $tarea->vista_en_checker = $row['vista_en_checker'];

                    array_push($tareas, $tarea);
                }   
                return $tareas;
            } catch (PDOException $e) {
                return [];
            }
        }
        
        function set_ok($id_tarea, $comentario){
            $query = $this->db->connect()->prepare("CALL CERRAR_TAREA(:id_usuario, :id_tarea, :estado, :comentario);");
            $query->execute([
                'id_usuario' => $_SESSION['id'],
                'id_tarea' => $id_tarea,
                'estado' => 'ok',
                'comentario' => $comentario]);
            return true;
        }

        function set_error($id_tarea, $comentario){
            $query = $this->db->connect()->prepare("CALL CERRAR_TAREA(:id_usuario, :id_tarea, :estado, :comentario);");
            $query->execute([
                'id_usuario' => $_SESSION['id'], 
                'id_tarea' => $id_tarea,
                'estado' => 'error',
                'comentario' => $comentario]);
            return true;
        }

        function set_mine($id_tarea){
            $query = $this->db->connect()->prepare("CALL ASIGNAR_TAREA(:id_usuario, :id_tarea);");
            $query->execute([
                'id_usuario' => $_SESSION['id'],
                'id_tarea' => $id_tarea
            ]);
            return true;
        }
    }
?> 