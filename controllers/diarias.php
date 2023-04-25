<?php
    class Diarias extends Controller{ 
        function __construct(){
            parent::__construct(); 
        } 

        function render(){
            $fecha = $this->get_fecha();
            $asignado = $this->get_usuario_asignado();
            
            $fechas = $this->model->get_fechas_con_pendientes();
            $this->view->fechas = $fechas;
            
            if ($fecha == "" ){
                $fecha = $fechas[0]['fecha'];
            }
            $this->view->fecha_show = $fecha;

            if ($asignado == ""){
                $tareas = $this->model->get_tareas_pendientes_por_fecha($fecha);
            } else {
                $tareas = $this->model->get_tareas_pendientes_asignadas($fecha,  $asignado);
            }
            $this->view->tareas = $tareas;
            $this->view->render('diarias/index');
        }

        function get_fecha(){
            if (isset($_COOKIE['fecha'])){
                $fecha = $_COOKIE['fecha'];
            } else {
                $fecha = "";
            } 
            return $fecha;
        }

        function get_usuario_asignado(){
            if (isset($_COOKIE['username'])){
                $usuario = $_COOKIE['username'];
            } else {
                $usuario = "";
            } 
            return $usuario;
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

        function set_mine(){
            $data = json_decode($_POST['data'], true);
            foreach($data as $d){
                $this->model->set_mine($d['id']);
            }
        }
    }
?>
