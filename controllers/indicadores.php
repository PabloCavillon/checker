<?php
    class Indicadores extends Controller{
        function __construct(){
            parent::__construct();
        }
        
        function render(){

            if(isset($_COOKIE['vista'])){
                switch($_COOKIE['vista']){
                    case 'diaria':
                        $this->diaria();
                        break;
                    case 'semanal':
                        $this->semanal();
                        break;
                    case 'mensual':
                        $this->mensual();
                        break;
                }
            } else {
                $this->diaria();
            }
            
            $periodo = $this->get_month();
            $this->view->emision =  $this->model->get_emision_mensual($periodo);
            $this->view->render('indicadores/index');
        }

        //Diaria
        function diaria(){
            $fecha = $this->get_day();
            $this->view->adquirencia = $this->model->get_adquirencia_fecha($fecha);
            return;
        }

        function get_day(){
            if (isset($_COOKIE['day'])){
                $fecha = $_COOKIE['day'];
            } else {
                $fecha = date('Y-m-d');
            } 
            return $fecha;
        }

        //Semanal
        function semanal(){
            $week = $this->get_week();
            $this->view->adquirencia = $this->model->get_adquirencia_semanal($week);
            return;
        }

        function get_week(){
            if (isset($_COOKIE['week'])){
                $week = $_COOKIE['week'];
            } else {
                $week = date('Y-m-d');
            } 
            return $week;
        }

        //Mensual
        function mensual(){
            $periodo = $this->get_month();
            $this->view->adquirencia = $this->model->get_adquirencia_mensual($periodo);
            return;
        }

        function get_month(){
            if (isset($_COOKIE['month'])){
                $month = $_COOKIE['month'];
            } else {
                $month = date('Y').date('m');
            } 
            return $month;
        }
    }
?> 
