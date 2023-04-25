<?php 
    class Rechazos_zcga010 extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;

            $cod_bancos = $this->model->get_bancos(); 

            $rechazos = $this->model->get_rechazos_zcga010($fecha);
            $this->view->rechazos = $rechazos;

            $tipos_rechazos = $this->model->get_tipos_de_rechazos($fecha);
            $this->view->tipos_rechazos = $tipos_rechazos;
        
            $rechazo_zgea500 = $this->model->get_rechazos_zgea500($fecha);
            $this->view->rechazo_zgea500 = $rechazo_zgea500;

            $this->view->render('rechazos_zcga010/index');
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