<?php
    class Autopresentacion extends Controller{ 
        function __construct(){
            parent::__construct(); 
        } 

        function render(){
            $this->view->render('autopresentacion/index');
        }
    }
?>