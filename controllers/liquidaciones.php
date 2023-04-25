<?php
    class Liquidaciones extends controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $asignado = $this->get_usuario_asignado();

            $fechas = $this->model->get_fechas_con_pendientes();
            $this->view->fechas = $fechas;

            if ($fecha == ""){ 
                $fecha = $fechas[0]['fecha'];
            }

            $this->view->fecha_show = $fecha;

            if ($asignado == ""){
                $liquidaciones = $this->model->get_liquidaciones_pendientes_por_fecha($fecha);
            } else {
                $liquidaciones = $this->model->get_liquidaciones_pendientes_asignadas($fecha,  $asignado);
            }

            $this->view->liquidaciones = $liquidaciones;
            $this->view->render('liquidaciones/index');
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

        function send_mail(){
            header('location: ' . constant('URL') . 'liquidaciones');
        }
    }
?>