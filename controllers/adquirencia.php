<?php
    class Adquirencia extends Controller{ 
        function __construct(){
            parent::__construct(); 
        } 
 
        function render(){

            $fecha = $this->get_fecha();
            $adquirecia = $this->model->get_adquirencia($fecha);

            $this->view->adquirencia = $adquirecia;
            $this->view->fecha = $fecha;

            $this->view->render('adquirencia/index');
        }

        function get_fecha(){
            if(isset($_COOKIE['fecha'])){
                $fecha = $_COOKIE['fecha'];
            } else {
                $fecha = date('Y-m-d');
            }
            return $fecha;
        }
    }
?>