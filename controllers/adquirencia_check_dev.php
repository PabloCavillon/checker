<?php
    class Adquirencia_check extends controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;

            $registros = $this->model->get_registros($fecha);
            $this->view->registros = $registros;
        
            $this->view->render('adquirencia_check/index');
        }

        function get_fecha(){
            if (isset($_COOKIE['fecha'])){
                $fecha = $_COOKIE['fecha'];
            } else {
                $fecha = date('Y-m-d');
            }
            return $fecha;
        }
    }
?>