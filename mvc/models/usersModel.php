<?php

class user_model {
    private $db;
    private $usuarios;

    public function __construct(){
        $this->db = Conectar::conexion();
        $this->usuarios = array();
    }

    public function get_users() {
        $sql = "SELECT * FROM usuarios";
        $resultado = $this->db->query($sql);
        while($row = $resultado->fetch_assoc()) {
            $this->usuarios[] = $row;
        }
        return $this->usuarios;
    }

    public function insertar($Nombre, $usuario, $password, $tipo_user, $sello) {
        $Nombre= $this->db->real_escape_string($Nombre);
        $usuario= $this->db->real_escape_string($usuario);
        $password= $this->db->real_escape_string($password);
        $tipo_user= $this->db->real_escape_string($tipo_user);
        $sello= $this->db->real_escape_string($sello);
        // Encriptar la contraseña antes de almacenarla en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $resultado = $this->db->query("INSERT INTO usuarios (usuario, tipo_user, Nombre, password, sello) VALUES ('$usuario', '$tipo_user', '$Nombre', '$hashed_password', '$sello')");
    }

    public function modificar($id, $tipo_user, $usuario , $password, $sello) {
        $id= $this->db->real_escape_string($id);
        $usuario= $this->db->real_escape_string($usuario);
        $password= $this->db->real_escape_string($password);
        $tipo_user= $this->db->real_escape_string($tipo_user);
        $sello= $this->db->real_escape_string($sello);
        // Encriptar la nueva contraseña antes de actualizarla en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $resultado = $this->db->query("UPDATE usuarios SET usuario='$usuario', tipo_user='$tipo_user', password='$hashed_password', sello='$sello' WHERE id = '$id'");
    }

    public function eliminar($id) {
        $resultado = $this->db->query("DELETE FROM usuarios WHERE id = '$id'");
    }

    public function get_user($id) {
        $sql = "SELECT * FROM usuarios WHERE id='$id' LIMIT 1";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        return $row;
    }

    public function es_administrador($usuarios) {
        // Consulta la base de datos para obtener el tipo de usuario
        $sql = "SELECT tipo_user FROM usuarios WHERE usuario = '$usuarios'";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        // Si el tipo de usuario es "admin", devuelve true, de lo contrario, devuelve false
        return ($row['tipo_user'] ?? null);
    }
    public function nombre_user($usuarios) {
        // Consulta la base de datos para obtener el tipo de usuario
        $sql = "SELECT Nombre FROM usuarios WHERE usuario = '$usuarios'";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        // Si el tipo de usuario es "admin", devuelve true, de lo contrario, devuelve false
        return ($row['Nombre'] ?? null);
    }
    public function usuario_user($usuarios) {
        // Consulta la base de datos para obtener el tipo de usuario
        $sql = "SELECT usuario FROM usuarios WHERE usuario = '$usuarios'";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        // Si el tipo de usuario es "admin", devuelve true, de lo contrario, devuelve false
        return ($row['usuario'] ?? null);
    }
    public function sello_user($usuarios) {
        // Consulta la base de datos para obtener el tipo de usuario
        $sql = "SELECT sello FROM usuarios WHERE usuario = '$usuarios'";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        // Si el tipo de usuario es "admin", devuelve true, de lo contrario, devuelve false
        return ($row['sello'] ?? null);
    }

    public function authenticate($usuario, $password) {
        return ($usuario === 'usuario' && $password === 'password');
    }
    public function getPasswordHashByUsername($usuario) {
        $conn = new mysqli("localhost", "root", "", "tamto");

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta para obtener el hash de la contraseña
        $sql = "SELECT password FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($password);

        // Obtener el resultado
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        return $password;
    }
    public function getUserIdByUsername($usuario) {
        $conn = new mysqli("localhost", "root", "", "tamto");

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta para obtener el ID del usuario
        $sql = "SELECT id FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($userId);

        // Obtener el resultado
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        return $userId;
    }

}
?>
