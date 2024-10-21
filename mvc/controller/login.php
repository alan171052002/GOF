<?php
require_once 'models/usersModel.php';

class LoginController
{
    // ... otros métodos ...

    public function index()
    {
        // Código para la acción principal si es necesario
        $view = new LoginViews();
        $view->render();


    }

    public function loginView()
{
    // Obtiene los valores directamente de $_POST
    $usuarios = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $model = new user_model();
    $storedPasswordHash = $model->getPasswordHashByUsername($usuarios);

    if ($storedPasswordHash && password_verify($password, $storedPasswordHash)) {
        $userId = $model->getUserIdByUsername($usuarios);

        // Verificar el tipo de usuario
        $tipoUsuario = $model->es_administrador($usuarios);
        $nombreUsuario = $model->nombre_user($usuarios);
        $nombreUsuarios=$model->usuario_user($usuarios);
        $sello=$model->sello_user($usuarios);

        // Establecer las sesiones
        $_SESSION['user_id'] = $userId;
        $_SESSION['usuario'] = $nombreUsuarios;
        $_SESSION['Nombre'] = $nombreUsuario;
        $_SESSION['tipo_usuario'] = $tipoUsuario;
        $_SESSION['sello'] = $sello;

        header("Location: /HTML/mvc/index.php");
        exit;
    } else {
        // Mostrar mensaje de error en la vista
        $view = new LoginViews();
        $view->render(['error' => 'Credenciales inválidas']);
    }
}

}

?>