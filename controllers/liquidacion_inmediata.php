<?php 
    class liquidacion_inmediata extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $fecha = $this->get_fecha();
            $this->view->fecha = $fecha;

            $cod_bancos = $this->model->get_bancos(); 

            $resumen = $this->model->get_inmediata_resumen($fecha);
            $this->view->resumen = $resumen;
            
            $tipos_rechazos = [];
            $bancos = [];
            foreach($cod_bancos as $cod_banco){
                $zlei001 = $this->model->get_zlei001($fecha, $cod_banco);
                $tc40 = $this->model->get_tc40($fecha, $cod_banco);
                $vnet = $this->model->get_vnet($fecha, $cod_banco);
                $rechazos = $this->model->get_rechazos($fecha, $cod_banco);
                $tipos_rechazos = $this->model->get_tipos_rechazos($fecha, $cod_banco, $tipos_rechazos);

                $banco = [
                    'cod_banco' => $cod_banco,
                    'zlei001' => $zlei001,
                    'tc40' => $tc40,
                    'vnet' => $vnet,
                    'rechazos' => $rechazos
                ];
                array_push($bancos, $banco);
            }
            $this->view->tipos_rechazos = $tipos_rechazos;
            $this->view->bancos = $bancos;

            $rechazos_por_lote = $this->model->get_rechazos_por_lote($fecha);
            $this->view->rechazos_por_lote = $rechazos_por_lote;

            $alertar_PCCGCOE = $this->model->get_alertar_PCCGCOE();
            $this->view->alertar_PCCGCOE = $alertar_PCCGCOE;

            $ultima_hora = $this->model->get_ultima_hora();
            $this->view->ultima_hora = $ultima_hora;

            $this->view->render('liquidacion_inmediata/index');
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