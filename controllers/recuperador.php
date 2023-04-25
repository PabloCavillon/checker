<?php
    class Recuperador extends Controller{
        function __construct(){
            if($_SESSION['tipo'] == 3){
                parent::__construct();

            } else {
                header('Location:'. constant('URL') . 'diarias');
            }
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;

            $tareas = $this->model->get_tareas($fecha);
            $this->view->tareas = $tareas;

            $this->view->render('recuperador/index');
        }

        function get_fecha(){
            if(isset($_COOKIE['fecha']) && $_COOKIE['fecha'] != ""){
                $fecha = $_COOKIE['fecha'];
            } else {
                $fecha = date('Y-m-d');
            }
            return $fecha;
        }

        function get_tarea(){
            $data = json_decode($_POST['data']);
            $tarea = $this->model->get_tarea($data->id);
            echo json_encode($tarea);
        }

        function set_ok(){
            $data = json_decode($_POST['data'], true);
            foreach($data as $d){
                $this->model->set_ok($d['id'], $d['comentario']);
            }
        }
        
        function set_error(){
            $data = json_decode($_POST['data'], true);
            foreach($data as $d){
                $this->model->set_error($d['id'], $d['comentario']);
            }
        }

        function download_excel(){
            $this->ftp->get_file();
        }
    }
?>
