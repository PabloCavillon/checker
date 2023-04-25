<?php 
    class Incidentes_model extends model{
        function __construct(){
            parent::__construct();
        }

        function get_incidentes($tags, $cantidad){

            $query = $this->db->connect()->prepare("CALL  ' + constant('DB') + '.buscar_incidente(:tag0,:tag1,:tag2,:tag3,:tag4,:tag5,:tag6,
                                                    :tag7,:tag8,:tag9,:tag10,:tag11,:tag12,:tag13,:tag14,:cantidad)");
            
            //Perdon por lo que sigue en el codigo, nos vimos limitados suerte
            $query->execute([
                'tag0' => (isset($tags[0])) ? $tags[0] : '',
                'tag1' => (isset($tags[1])) ? $tags[1] : '',
                'tag2' => (isset($tags[2])) ? $tags[2] : '',
                'tag3' => (isset($tags[3])) ? $tags[3] : '',
                'tag4' => (isset($tags[4])) ? $tags[4] : '',
                'tag5' => (isset($tags[5])) ? $tags[5] : '',
                'tag6' => (isset($tags[6])) ? $tags[6] : '',
                'tag7' => (isset($tags[7])) ? $tags[7] : '',
                'tag8' => (isset($tags[8])) ? $tags[8] : '',
                'tag9' => (isset($tags[9])) ? $tags[9] : '',
                'tag10' => (isset($tags[10])) ? $tags[10] : '',
                'tag11' => (isset($tags[11])) ? $tags[11] : '',
                'tag12' => (isset($tags[12])) ? $tags[12] : '',
                'tag13' => (isset($tags[13])) ? $tags[13] : '',
                'tag14' => (isset($tags[14])) ? $tags[14] : '',
                'cantidad' => $cantidad 
            ]);

            $items = [];
            while($row = $query->fetch()){
                $item = [
                    'banco' =>            $row['banco'],
                    'usuario' =>          $row['usuario'],
                    'numero_incidente' => $row['numero_incidente'],
                    'fecha' =>            $row['fecha'],
                    'tema' =>             $row['descripcion']
                ];
                array_push($items, $item);
            }
            return $items;
        } 

        function get_bancos_activos() {
            $query = $this->db->connect()->prepare("SELECT 
                                                        id, abreviatura
                                                    FROM
                                                        " + constant('DB') + ".view_bancos_activos;");
            $query->execute();

            $items = [];
            while($row = $query->fetch()) {
                $item = [
                   'codigo' => $row['id'],
                   'nombre' => $row['abreviatura']
                ];
                array_push($items, $item);
            }

            return $items;
        }

        function load_incidente($banco, $numero, $fecha, $tema) {
            $query = $this->db->connect()->prepare("CALL  ' + constant('DB') + '.insert_log_incidentes(:banco, :usuario, :numero, :fecha, :tema);");
            $query->execute([
                'banco' => $banco,
                'usuario' => $_SESSION['id'],
                'numero' => $numero,
                'fecha' => $fecha,
                'tema' => $tema
            ]);

            return true;
        }

        function load_tags($numero, $tag) {
            $query = $this->db->connect()->prepare("CALL  ' + constant('DB') + '.insert_tags_x_incidente(:numero, :tag);");
            $query->execute([
                'numero' => $numero,
                'tag' => $tag
            ]);

            return true;
        }

    } 
?>