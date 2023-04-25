<?php
    class Zina010_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_zina010(){
            $query = $this->db->connect()->prepare('SELECT * FROM  ' + constant('DB') + '.view_listado_zina010 ORDER BY fecha_encontrado desc;');
            $query->execute();

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'codop' => $row['codop'],
                    'evento' => $row['evento'],
                    'origen' => $row['origen'],
                    'sent' => $row['sent'],
                    'encontrado' => $row['fecha_encontrado'],
                    'ultimo_descarte' => $row['fecha_ultimo_descarte'],
                    'validado' => $row['validado']
                ];
                array_push($items, $item);
            }

            return $items;
        }
    }
?>