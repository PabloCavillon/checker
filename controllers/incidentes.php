<?php

    class Incidentes extends Controller{
        function __construct(){
            parent::__construct();
        }
        
        function render() {

            $tags = $this->get_tags();

            $tags_arr = explode(" ", $tags);

            $cantidad_tags = count($tags_arr);

            $incidentes = $this->model->get_incidentes($tags_arr, $cantidad_tags);

            $bancos = $this->model->get_bancos_activos();

            $this->view->bancos = $bancos;
            $this->view->incidentes = $incidentes;

            $this->view->render('incidentes/index');
        }

        function get_tags(){
            $tags = ""; 
            if (isset($_COOKIE['tags'])){
                $tags = $_COOKIE['tags'];
            } 
            return $tags;
        }

        function load_incidente (){
            $data = json_decode($_POST['data'], true);
            $this->model->load_incidente($data[0]['banco'], $data[0]['numero'], $data[0]['fecha'], $data[0]['tema']);

            foreach($data as $d){ 
                $this->model->load_tags($d['numero'], $d['tag']);
            }
        }
    }
?>