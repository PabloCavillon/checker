<?php 
    class Alertas_spv extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha =$fecha;

            $alertas = $this->model->get_alertas($fecha);
            $this->view->alertas = $alertas;

            $this->view->render('alertas_spv/index');
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