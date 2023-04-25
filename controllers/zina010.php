<?php
    class Zina010 extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $data = $this->model->get_zina010();
            $this->view->data = $data;
             
            $this->view->render('zina010/index');
        }
    }
?> 