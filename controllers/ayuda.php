<?php
    class Ayuda extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $this->view->render('ayuda/index');
        }

        function mostrar($data){
            $this->view->titulo =  $data[0];
            $this->render();
        }
    }
?>