<?php
    class Mensajeria_cajas_autorizado_vs_presentacion extends Controller{ 
        function __construct(){
            parent::__construct(); 
        } 

        function render(){
            $this->view->render('Mensajeria_cajas_autorizado_vs_presentacion/index');
        }
    }
?>