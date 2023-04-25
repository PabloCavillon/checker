<?php 
    class Rechazos_zcga extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;

            $rechazos = $this->model->get_rechazos($fecha);
            $this->view->rechazos = $rechazos;

            $this->view->render('rechazos_zcga/index');
        }

        function get_fecha(){
            if(isset($_COOKIE['fecha'])){
                $fecha = $_COOKIE['fecha'];
            } else {
                if ( date('H') > 17 ) {
                    $fecha = date('Y-m-d');
                }
                else {
                    $date = date( "Y-m-d" );
                    $fecha = date( "Y-m-d", strtotime( "-1 day", strtotime( $date ) ) );
                }
            }
            return $fecha;
        }
    }
?>