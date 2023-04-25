<?php
    session_start();
    class App{
        function __construct(){ 
            //Tomamos la url (definida en .htaccess)
            $url = isset($_GET['url']) ? $_GET['url'] : null;
            
            //Se obvia el exceso del caracter '/' 
            $url = rtrim($url, '/');
             
            //Separamos la url con a partir del caracter '/' 
            $url = explode('/', $url);
         
            $archivoController = 'controllers/' . $url[0] . '.php';
            
            if (empty($url[0])){
                header('location:'.constant('URL').'diarias');
                return false;
            }
         
            if (file_exists($archivoController)){
                require_once $archivoController;
                $controller = new $url[0];
                $controller->load_model($url[0]);

                $nparam = sizeof($url);
 
                if ($nparam > 1){
                    if($nparam > 2){
                        $param = [];
                        for ($i = 2; $i<$nparam; $i++){
                            array_push($param, $url[$i]);
                        }
                        $controller->{$url[1]}($param);
                    } 
                    else{
                        $controller->{$url[1]}();
                    }
                } else {
                    $controller->render();
                }
            } else {
                header('location:'.constant('URL').'diarias');
                return false;
            }
        }
    }
?>