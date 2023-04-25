<?php
    class Controller{
        function __construct(){
            if(isset($_SESSION['id'])){
                $this->view = new View();
                $this->ftp = new FTP();
            } else {
                header('Location:'. constant('URL') . 'login');
            }
        }

        function load_model($model){
            $url = "models/" . $model . "_model.php";

            if (file_exists($url)){
                require $url;

                $model_name = $model.'_Model';
                $this->model = new $model_name();
            }
        }
    }
?>