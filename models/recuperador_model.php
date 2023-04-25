<?php 
    include_once 'models/class/tarea.php';

    class Recuperador_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_tareas($fecha){
            $query = $this->db->connect()->prepare('CALL GET_TAREAS_POR_FECHA(:fecha)');
            $query->execute(['fecha' => $fecha]);

            $tareas = [];
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
                $tarea->estado_recuperado = $row['estado_recuperado'];
                $tarea->usuario_recuperador = $row['usuario_recuperador'];
                $tarea->fecha_recuperado = $row['fecha_recuperado'];
                $tarea->causa_recuperado = $row['causa_recuperado'];
            
                array_push($tareas, $tarea);
            }
            return $tareas;
        }

        function get_tarea($id){
            $query = $this->db->connect()->prepare('CALL GET_TAREA_POR_ID(:id);');
            $query->execute(['id' => $id]);
            
            $row = $query->fetch();

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
            $tarea->estado_recuperado = $row['estado_recuperado'];
            $tarea->usuario_recuperador = $row['usuario_recuperador'];
            $tarea->fecha_recuperado = $row['fecha_recuperado'];
            $tarea->causa_recuperado = $row['causa_recuperado'];

            return $tarea;
        }

        function set_ok($id_tarea, $comentario){
            $query = $this->db->connect()->prepare("CALL RECUPERAR_TAREA(:id_usuario, :id_tarea, :estado, :comentario);");
            echo ($_SESSION['id'] . " " . $id_tarea  . " " . 'ok' . " " . $comentario);
            $query->execute([
                'id_usuario' => $_SESSION['id'],
                'id_tarea' => $id_tarea,
                'estado' => 'ok',
                'comentario' => $comentario
            ]);
            return true;
        }

        function set_error($id_tarea, $comentario){
            $query = $this->db->connect()->prepare("CALL RECUPERAR_TAREA(:id_usuario, :id_tarea, :estado, :comentario);");
            $query->execute([
                'id_usuario' => $_SESSION['id'], 
                'id_tarea' => $id_tarea,
                'estado' => 'error',
                'comentario' => $comentario
            ]);
            return true;
        }
    }
?>