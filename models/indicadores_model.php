<?php
    class Indicadores_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_adquirencia_fecha($fecha){
            $query = $this->db->connect()->prepare('CALL GET_INDICADORES_ADQUIRENCIA_DIARIOS(:fecha)');
            $query->execute([
                'fecha' => $fecha
            ]);

            $data = [];
            while($row = $query->fetch()){
                if(isset($data[$row['banco']])){
                        $data[$row['banco']]['movimientos'] += $row['movimientos'];
                        $data[$row['banco']]['liquidaciones'] += $row['liquidaciones'];
                } else {
                    $data[$row['banco']] = [
                        'banco' => $row['banco'],
                        'movimientos' => $row['movimientos'],
                        'liquidaciones' => $row['liquidaciones']  
                    ];
                }
            }

            $indicadores = [];
            foreach($data as $i){
                $indicador = [
                    'banco' => $i['banco'],
                    'movimientos' => $i['movimientos'],
                    'liquidaciones' => $i['liquidaciones'],
                ];
                array_push($indicadores, $indicador);
            }

            return $indicadores;
        }

        function get_adquirencia_semanal($week){
            $query = $this->db->connect()->prepare('CALL GET_INDICADORES_ADQUIRENCIA_SEMANAL(:week)');
            $query->execute([
                'week' => $week
            ]);

            $data = [];
            while($row = $query->fetch()){
                if(isset($data[$row['banco']])){
                        $data[$row['banco']]['movimientos'] += $row['movimientos'];
                        $data[$row['banco']]['liquidaciones'] += $row['liquidaciones'];
                } else {
                    $data[$row['banco']] = [
                        'banco' => $row['banco'],
                        'movimientos' => $row['movimientos'],
                        'liquidaciones' => $row['liquidaciones']  
                    ];
                }
            }

            $indicadores = [];
            foreach($data as $i){
                $indicador = [
                    'banco' => $i['banco'],
                    'movimientos' => $i['movimientos'],
                    'liquidaciones' => $i['liquidaciones'],
                ];
                array_push($indicadores, $indicador);
            }

            return $indicadores;
        }

        function get_adquirencia_mensual($periodo){
            $query = $this->db->connect()->prepare('CALL GET_INDICADORES_ADQUIRENCIA_MENSUAL(:periodo);');
            $query->execute([
                'periodo' => $periodo
            ]);

            $data = [];
            while($row = $query->fetch()){
                if(isset($data[$row['banco']])){
                        $data[$row['banco']]['movimientos'] += $row['movimientos'];
                        $data[$row['banco']]['liquidaciones'] += $row['liquidaciones'];
                } else {
                    $data[$row['banco']] = [
                        'banco' => $row['banco'],
                        'movimientos' => $row['movimientos'],
                        'liquidaciones' => $row['liquidaciones']  
                    ];
                }
            }

            $indicadores = [];
            foreach($data as $i){
                $indicador = [
                    'banco' => $i['banco'],
                    'movimientos' => $i['movimientos'],
                    'liquidaciones' => $i['liquidaciones'],
                ];
                array_push($indicadores, $indicador);
            }

            return$indicadores;
        }

        function get_emision_mensual($periodo){
            $query = $this->db->connect()->prepare('CALL GET_INDICADORES_EMISION_MENSUAL(:periodo);');
            $query->execute([
                'periodo' => $periodo
            ]);

            $indicadores = [];
            while($row = $query->fetch()){
                $indicador = [
                    'cartera'                 => $row['cartera'],
                    'cuentas'                 => $row['cuentas'],
                    'cuentas_con_movimientos' => $row['cuentas_con_movimientos'],
                    'movimientos'             => $row['movimientos']
                ];
                array_push($indicadores, $indicador);
            }

            return$indicadores;
        }
    }
?>  