<?php 
    class Bancos extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $bancos = $this->model->get_bancos();
            $this->view->bancos = $bancos;
            
            $this->view->render('bancos/index');
        }

        function get_info(){
            $banco = json_decode($_POST['data'], true);
            $coordinadores = $this->model->get_coordinadores_por_banco($banco['id']);
            $carteras = $this->model->get_carteras_por_banco($banco['id']);
            $respuesta = [
                'coordinadores' => $coordinadores,
                'carteras'      => $carteras
            ];
            echo json_encode($respuesta);
        }
    }
?>