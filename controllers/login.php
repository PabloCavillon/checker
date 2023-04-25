<?php 
    class Login extends Controller{
        function __construct(){
            if(isset($_SESSION['user'])){
                header("Location: " . constant('URL') . "diarias");
            } else {
                $this->view = new View();
            }
        }

        function render(){
            $this->view->render('login\index');
        }

        function verificar(){
            $usuario = $_POST['usuario'];
            $pass = $_POST['password'];

            $user = $this->model->get_usuario(['username' => $usuario, 'pass' => $pass]);

            if (isset($user->id)){
                $_SESSION['id'] = $user->id;
                $_SESSION['apenom'] = $user->apenom;
                $_SESSION['username'] = $user->username;
                $_SESSION['apodo'] = $user->apodo;
                $_SESSION['tipo'] = $user->tipo;
                $_SESSION['interno'] = $user->interno;
                $_SESSION['cumple'] = $user->cumple;
                header('Location:'.constant('URL').'diarias');
            } else {
                header('Location:'.constant('URL').'login');
            }
        }

        function cerrar_sesion(){
            session_destroy();
            $_SESSION = array();
            header('Location: '.constant('URL').'login');
            die();
        }
    }
?>