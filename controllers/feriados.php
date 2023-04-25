<?php
    class feriados extends Controller{
        function __construct(){
            parent::__construct();
        }
 
        function render(){
            $year = "";
            if(isset($_COOKIE['year'])){
                $year = $_COOKIE['year'];
            } else {
                $year = date('Y');
            }
            $this->view->year = $year;

            $feriados_query = $this->model->get_feriados($year);

            $feriados = [];
            foreach ($feriados_query as $feriado){
                if(isset($feriados[$feriado['id_feriado']])){
                    $feriados[$feriado['id_feriado']] = [
                        'id_feriado' =>     $feriado['id_feriado'],
                        'dia' =>            $feriado['dia'],
                        'mes' =>            $feriado['mes'],
                        'year' =>           $feriado['year'],
                        'descripcion' =>    $feriado['descripcion'],
                        'apodo' =>          $feriados[$feriado['id_feriado']]['apodo'] . " - " . $feriado['apodo']
                    ];
                } else {
                    $feriados[$feriado['id_feriado']] = [
                        'id_feriado' =>     $feriado['id_feriado'],
                        'dia' =>            $feriado['dia'],
                        'mes' =>            $feriado['mes'],
                        'year' =>           $feriado['year'],
                        'descripcion' =>    $feriado['descripcion'],
                        'apodo' =>          $feriado['apodo']
                    ];
                }
            }

            $this->view->feriados = $feriados;

            $this->view->render('feriados/index');
        } 

        function asignar(){ 
            $data = json_decode($_POST['data'], true);
            var_dump($data);
            foreach($data as $d){
                $this->model->set_feriado($d['id'], $_SESSION['id']);
            }
        }

        function desasignar(){
            $data = json_decode($_POST['data'], true);
            foreach($data as $d){
                $this->model->unset_feriado($d['id'], $_SESSION['id']);
            }
        }

        function agregar_feriado(){
            $data = json_decode($_POST['data'], true);
            $this->model->agregar_feriado($data['conmemoracion'], $data['dia'], $data['mes'], $data['year']);
        }

        function eliminar_feriado(){
            $data = json_decode($_POST['data'], true);
            $this->model->eliminar_feriado($data['id_feriado']);
        }
    }
?>