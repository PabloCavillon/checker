<?php

	class Rad_model extends Model {

		function __construct() {
			parent::__construct();
		}

		function get_data ($periodo) {
			$query = $this->db->connect()->prepare("SELECT banco, cartera, tipo_cartera, cuentas_totales FROM  " + constant('DB') + ".cuentas_emision WHERE periodo = :periodo ORDER BY cartera desc, tipo_cartera, banco ;");
            $query->execute(['periodo' => $periodo]);

            $items = [];
            while ($row = $query->fetch()) {
 				$item = [
	            	'banco' => $row['banco'],
	            	'cartera' => $row['cartera'],
	            	'tipo' => $row['tipo_cartera'],
	            	'cantidad' => $row['cuentas_totales']
	            ];

	            array_push($items, $item);
            }

            return $items;
 		}

		function get_min_max_periodo () {
			$query = $this->db->connect()->prepare("SELECT min(periodo) as min, max(periodo) as max FROM  " + constant('DB') + ".cuentas_emision");
			$query->execute();

			$periodos = [];
			while ($row = $query->fetch()) {
	           	$periodos = [
	           		'min' => substr($row['min'], 0, -2) . "-" . substr($row['min'], 4),
	           		'max' => substr($row['max'], 0, -2) . "-" . substr($row['max'], 4)
            	];
            }

            return $periodos;
		}
	}

?>