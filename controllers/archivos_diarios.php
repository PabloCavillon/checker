<?php
    class Archivos_diarios extends Controller {
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;

            $archivos = $this->model->get_archivos_diarios($fecha);
            $this->view->archivos = $archivos;

            $resumenes = [];
            foreach($archivos as $archivo){
                $resumenes[$archivo['nombre']] = $this->model->get_detalle($archivo['nombre'], $fecha);
            }
            $this->view->resumenes = $resumenes;
            
            $periodo = $this->get_periodo();
            $this->view->data = $this->model->get_data_grafico($periodo);

            $this->view->render('archivos_diarios/index');
        }
 
        function get_fecha(){
            if (isset($_COOKIE['fecha'])){
                $fecha = $_COOKIE['fecha'];
            } else {
                $fecha = date('Y-m-d');
            } 
            return $fecha;
        }

        function get_periodo(){
            if (isset($_COOKIE['fecha'])){
                return substr($_COOKIE['fecha'], 0, -2);                
            } else {
                return date('Ym');
            } 
        }
    }
?>