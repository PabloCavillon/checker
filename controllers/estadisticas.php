<?php 
    class Estadisticas extends Controller{
        function __construct(){
            parent::__construct();
        }

        function render(){
            $this->view->meses = $this->set_meses();
            $mes = "";
            if(isset($_COOKIE['mes'])){
                $mes = $_COOKIE['mes'];
            } else {
                $mes = date('m');
            }
            $this->view->mes = $mes;

            $year = "";
            if(isset($_COOKIE['year'])){
                $year = $_COOKIE['year'];
            } else {
                $year = date('Y');
            }
            $this->view->year = $year;
            $periodo = $year . $mes;
            
            $tareas = $this->model->get_estadisticas_tareas($periodo);
            $this->view->tareas = $tareas;
            $tareas_error = $this->model->get_estadisticas_tareas_por_estado($periodo, 'ERROR');
            $this->view->tareas_error = $tareas_error;
            $tareas_ok = $this->model->get_estadisticas_tareas_por_estado($periodo,'OK');
            $this->view->tareas_ok = $tareas_ok;

            $liquis = $this->model->get_estadisticas_liquis($periodo);
            $this->view->liquis = $liquis;
            $liquis_error = $this->model->get_estadisticas_liquis_por_estado($periodo,'ERROR');
            $this->view->liquis_error = $liquis_error;
            $liquis_ok = $this->model->get_estadisticas_liquis_por_estado($periodo,'OK');
            $this->view->liquis_ok = $liquis_ok;
            
            $this->view->render('estadisticas/index');
        }

        function set_meses(){
            $meses = [
                '01' => 'ENERO', 
                '02' => 'FEBRERO',
                '03' => 'MARZO',
                '04' => 'ABRIL',
                '05' => 'MAYO',
                '06' => 'JUNIO',
                '07' => 'JULIO',
                '08' => 'AGOSTO',
                '09' => 'SEPTIEMBRE',
                '10' => 'OCTUBRE',
                '11' => 'NOVIEMBRE',
                '12' => 'DICIEMBRE'
            ];
            return $meses;
        }
    }
?>