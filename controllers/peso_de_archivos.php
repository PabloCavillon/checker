<?php
    class Peso_de_archivos extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            if (isset($_COOKIE['mes']) && isset($_COOKIE['year'])){
                $mes = $_COOKIE['mes'];
                $year = $_COOKIE['year'];
            } else {
                $mes = date('m');
                $year = date('Y');
            }
            $this->view->mes = $mes;
            $this->view->year = $year;

            $periodo = $year.$mes;      

            $cartera = $this->get_cartera();
            $this->view->cartera = $cartera;

            $pesos = $this->model->get_pesos_de_archivos($periodo, $cartera);
            $this->view->pesos = $pesos;

            $meses = $this->set_meses();
            $this->view->meses = $meses;

            $carteras = $this->model->get_carteras();
            $this->view->carteras = $carteras;
            
            $this->view->render('peso_de_archivos/index');
        }

        function get_cartera(){
            if (isset($_COOKIE['cartera'])){
                $cartera = $_COOKIE['cartera'];
            } else {
                $cartera = "0".date('d', strtotime('-1 day'));
            }
            return $cartera;
        }

        function set_meses(){
            $meses = [
                '01' => 'ENERO', 
                '02' => 'FEBRERO',
                '03' => 'MARZO',
                '04' => 'ABRIL',
                '05' => 'MAYO',
                '06' => 'JUNIO',
                '07' => 'JULIO',
                '08' => 'AGOSTO',
                '09' => 'SEPTIEMBRE',
                '10' => 'OCTUBRE',
                '11' => 'NOVIEMBRE',
                '12' => 'DICIEMBRE'
            ];
            return $meses;
        }
    }
?>