<?php
    class Conciliacion extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;
            
            $visa = $this->model->get_conciliacion_visa($fecha);
            $this->view->conciliacion = $visa;

            $fechas = $this->model->get_max_min_fechas_visa($fecha);
            $this->view->fechas = $fechas;

            $this->view->render('conciliacion/index');
        }

        function get_fecha() {
            $fecha = date('Y-m-d', strtotime(date("Y-m-d")));
            if (isset($_COOKIE['fecha'])) {
                $fecha = $_COOKIE['fecha'];
            }

            return $fecha;
        }
    }
?>