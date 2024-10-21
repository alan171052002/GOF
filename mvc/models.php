<?php
class users_model {
		
    private $db;
    private $users;
    
    public function __construct(){
        $this->db = Conectar::conexion();
        $this->users = array();
    }
    
    public function get_users()
    {
        $sql = "SELECT * FROM users";
        $resultado = $this->db->query($sql);
        while($row = $resultado->fetch_assoc())
        {
            $this->users[] = $row;
        }
        return $this->users;
    }
    
    public function insertar($nombre, $email, $password, $tipo_user){
        
        $resultado = $this->db->query("INSERT INTO usuarios (nombre, usuario, password, tipo_user) VALUES ('$nombre', '$email', '$password', 'usuario')");
        
    }
    
    public function modificar($id, $nombre, $usuario, $password, $tipo_user){
        
        $resultado = $this->db->query("UPDATE usuarios SET  nombre='$nombre', usuario='$usuario', password='$password', tipo_user='$tipo_user' WHERE id = '$id'");			
    }
    
    public function eliminar($id){
        
        $resultado = $this->db->query("DELETE FROM usuarios WHERE id = '$id'");
        
    }
    
    public function get_user($id)
    {
        $sql = "SELECT * FROM users WHERE id='$id' LIMIT 1";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        return $row;
    }
}


?>