<?php
    class Adquirencia_check_model extends model{
        function __construct(){
            parent::__construct();
        }

        function get_registros($fecha){
            $query = $this->db->connect()->prepare('call movimientos_estliq_vs_pccgcoe(:fecha);');
            $query->execute(['fecha' => $fecha]);

            $items = [];
            while ($row = $query->fetch()){
                $item = [
                    'banco'         => $row['banco_informante'],
                    'autorizacion'  => $row['numero_autorizacion'],
                    'tarjeta'       => $row['numero_tarjeta'],
                    'pdv'           => $row['numero_punto_de_venta'],
                    'importe'       => $row['importe_total_del_movimiento'],
                    'estliq'     => $row['estliq']
                ];
                array_push($items, $item);
            }
            return $items;
        }
    }
?>