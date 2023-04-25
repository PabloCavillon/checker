<?php
    class Adquirencia_new extends Controller{ 
        function __construct(){
            parent::__construct(); 
        } 

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;
            
            $banco = $this->get_banco(); 

            $adq_fecha = [];
            for($i = 0; $i < 9; $i++ ){
                array_push($adq_fecha, $this->model->get_adquirencia($fecha, $banco));
                $fecha = date( "Y-m-d", strtotime("-1 day", strtotime( $fecha ))); 
            }

            $this->view->adq_fecha = $adq_fecha;
            

            $this->view->render('adquirencia_new/index');
        }

        function get_fecha(){
            if(isset($_COOKIE['fecha'])){
                $fecha = $_COOKIE['fecha'];
            } else {
                $fecha = date('Y-m-d');
            }
            return $fecha;
        }

        function get_banco() {
            if(isset($_COOKIE['banco'])){
                $fecha = $_COOKIE['banco'];
            } else {
                $fecha = '701';
            }
            return $fecha;
        }
    }
?>