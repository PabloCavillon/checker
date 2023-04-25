<?php
	class Rad extends Controller {
		
		function __construct() {
			parent::__construct();
		}

		function render() {
			$periodos = $this->model->get_min_max_periodo();
			$this->view->periodos = $periodos;

			$periodo = $this->get_periodo($periodos['max']);
			$this->view->periodo = $periodo;

			$periodo = str_replace("-", "", $periodo);

			$data = $this->model->get_data($periodo);
			$this->view->data = $data;

			$this->view->render('rad/index');			
		}

		function get_periodo ($max_periodo) {
			if (isset($_COOKIE['periodo'])) {
				$periodo = $_COOKIE['periodo'];
			} else {
				$periodo = $max_periodo;
			}			

			return $periodo;
		}
	}
?>