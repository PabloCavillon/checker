<?php 
    require_once 'class/usuario.php';
    class Login_model extends Model{
        function __construct(){
            parent::__construct();
        }

        function get_usuario($data){
            try{
                $user = new Usuario();
                $query = $this->db->connect()->prepare("CALL get_usuario(:username, :pass);");
                $query->execute($data);

                while($row = $query->fetch()){
                    $user->id = $row['id'];
                    $user->nombre = $row['nombre'];
                    $user->apellido = $row['apellido'];
                    $user->username = $row['username'];
                    $user->apodo = $row['apodo'];
                    $user->tipo = $row['tipo'];
                    $user->cumple = $row['cumple'];
                    $user->interno = $row['interno'];
                }
                return $user;
            } catch (PDOException $e) {
                return [];
            }
        }
    }

?>