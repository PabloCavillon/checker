<?php
    class Pre_liquidaciones extends controller{
        function __construct(){
            parent::__construct();
        }

        function render(){ 

            $usuario = $this->get_usuario_asignado();

            $carteras = $this->model->get_carteras_con_pendientes($usuario);
            $pre_liquidaciones = $this->model->get_preliquidaciones_pendientes($usuario);
    
            $this->view->carteras = $carteras;
            $this->view->pre_liquidaciones = $pre_liquidaciones;

            $this->view->render('pre_liquidaciones/index');
        }

        function get_usuario_asignado(){
            if (isset($_COOKIE['username'])){
                $usuario = $_COOKIE['username'];
            } else {
                $usuario = "";
            } 
            return $usuario;
        }

        function set_ok(){
            $data = json_decode($_POST['data'], true);
            foreach($data as $d){
                $this->model->set_ok($d['id'], $d['comentario']);
            }
        }
        
        function set_error(){
            $data = json_decode($_POST['data'], true);
            foreach($data as $d){
                $this->model->set_error($d['id'], $d['comentario']);
            }
        }

        function set_mine(){
            $data = json_decode($_POST['data'], true);
            var_dump($data);
            foreach($data as $d){
                $this->model->set_mine($d['id']);
            }
        }
    }
?>