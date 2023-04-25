<?php
    class Llegada_de_archivos extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;

            $archivos = $this->model->get_archivos($fecha);
            $this->view->archivos = $archivos;
            
            $this->view->render('llegada_de_archivos/index');
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