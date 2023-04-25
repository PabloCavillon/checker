<?php

	class Codops extends Controller{
		function __construct() {
			parent::__construct();
		}

		function render() {
			$periodo = $this->get_periodo();
			$this->view->periodo = $periodo;

			$codops_nuevos = $this->model->get_codops_nuevos();
			$this->view->codops_nuevos = $codops_nuevos;

			$codops_desaparecidos = $this->model->get_codops_desaparecidos();
			$this->view->codops_desaparecidos = $codops_desaparecidos;

			$cruce_codops = $this->model->get_cruce_codops();
			$this->view->cruce_codops = $cruce_codops;

			$this->view->reder('codops/index');
		}

		function get_periodo(){
			$periodo = date('Y-m');
			if (isset($_COOKIE['periodo'])) {
				$periodo = $_COOKIE['periodo'];
			}

			return $periodo

		}
	}


?>