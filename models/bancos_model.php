<?php 
    class Bancos_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_bancos(){
            $query = $this->db->connect()->prepare('SELECT * FROM " + constant('DB') + ".bancos WHERE id LIKE  \'7%\' order by id;');
            $query->execute();
            $bancos = [];
            while($row = $query->fetch()){
                $banco = [
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'abreviatura' => $row['abreviatura'],
                    'pais' => $row['pais'],
                    'emision' => $row['emision'],
                    'adquirencia' => $row['adquirencia'],
                    'inmediata' => $row['adq_inmediata']
                ];
                array_push($bancos, $banco);
            }
            return $bancos;
        }

        function get_carteras_por_banco($banco){
            $query = $this->db->connect()->prepare('SELECT cartera, tipo FROM " + constant('DB') + ".view_bancos_x_cartera Where banco = :banco;');
            $query->execute([
                'banco' => $banco
            ]);         

            $carteras = [];
            while($row = $query->fetch()){
                $cartera = [
                    "cartera" => $row['cartera'],
                    "tipo"   => $row['tipo']
                ];
                array_push($carteras, $cartera);
            }
            return $carteras;
        }

        function get_coordinadores_por_banco($banco){
            $query = $this->db->connect()->prepare('SELECT coordinador, apellido, interno FROM " + constant('DB') + ".view_coordinadores_x_banco WHERE banco = :banco;');
            $query->execute([
                'banco' => $banco
            ]);

            $coordinadores = [];
            while($row = $query->fetch()){
                $coordinador = [
                    'apenom' => strtoupper($row['Apellido']) . ', ' . $row['Coordinador'],
                    'interno' => $row['interno']  
                ];
                array_push($coordinadores, $coordinador);
            }
            return $coordinadores;
        }
    }
?>