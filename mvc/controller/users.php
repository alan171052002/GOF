<?php

class usersController
{//empleados

	public function __construct()
	{
		require_once "models/usersModel.php";
	}

	public function index()
	{
		if (!(isset ($_SESSION['user_id']) && isset ($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin')) {
			// Si el usuario no está autenticado o no es administrador, redirigir a la página de inicio de sesión o mostrar un mensaje de error
			header('Location: \HTML\mvc\index.php');
			exit; // Asegura que el script se detenga después de redirigir
		}
		require_once "models/usersModel.php";

		$users = new user_model();
		$data["titulo"] = "Usuarios";
		$data["usuarios"] = $users->get_users();

		require_once "views/users/users.php";
	}

	public function nuevo()
	{

		$data["titulo"] = "Usuarios";
		require_once "views/users/users_nuevo.php";
	}

	public function guarda()
	{
		// Obtener datos del formulario
		$Nombre = $_POST['Nombre'];
		$tipo_user = $_POST['tipo_user'];
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];

		// Verificar si el usuario ya existe
		$users = new user_model();
		$existingUser = $users->getUserIdByUsername($usuario);

		if ($existingUser) {
			echo "El usuario ya existe.";
			return;
		}

		// Manejar la carga del archivo de sello
		if (isset ($_FILES['sello']) && $_FILES['sello']['error'] === UPLOAD_ERR_OK) {
			// Procesar el archivo de sello y realizar la inserción en la base de datos
			$sello_tmp_name = $_FILES['sello']['tmp_name'];
			$sello_extension = pathinfo($_FILES['sello']['name'], PATHINFO_EXTENSION);
			$nombre_archivo_sello = $usuario . '.' . $sello_extension;
			$sello_destination = 'sellos/' . $nombre_archivo_sello;

			if (move_uploaded_file($sello_tmp_name, $sello_destination)) {
				// Insertar el usuario en la base de datos
				$users->insertar($Nombre, $usuario, $password, $tipo_user, $sello_destination);
				echo "Usuario agregado correctamente.";
			} else {
				echo "Error al mover el archivo de sello.";
			}
		} else {
			$users->insertar($Nombre, $usuario, $password, $tipo_user, null);
				echo "Usuario agregado correctamente sin sello.";
		}

		// Redireccionar o mostrar la página principal de usuarios
		$data["titulo"] = "Usuarios";
		
		header("Location: home.php?c=users&a=index");
        exit(); 
	}
	public function modificar($id)
	{
		$users = new user_model();
		$data["id"] = $id;

		// Obtener los datos del usuario
		$userData = $users->get_user($id);

		// Verificar si se encontraron datos del usuario
		if ($userData) {
			// Si se encontraron datos del usuario, pasar el nombre del usuario a los datos que envías a la vista
			$data["nombre"] = $userData["Nombre"];
			$data["users"] = $userData;
			$data["titulo"] = "Usuario:<br><br>" . $userData["Nombre"];
		} else {
			// Si no se encontraron datos del usuario, manejar el caso de error apropiadamente
			$data["titulo"] = "Usuario no encontrado";
		}

		require_once "views/users/users_modifica.php";
	}

	public function actualizar()
	{
		$id = $_POST["id"];
		$usuario = $_POST['usuario'];
		$tipo_user = $_POST['tipo_user'];
		$password = $_POST['password'];

		// Obtener el nombre de archivo del sello
		$sello_tmp_name = $_FILES['sello']['tmp_name'];
		$sello_extension = pathinfo($_FILES['sello']['name'], PATHINFO_EXTENSION); // Obtener la extensión del archivo de sello

		// Construir el nuevo nombre de archivo para el sello utilizando el nombre de usuario
		$nombre_archivo_sello = $usuario . '.' . $sello_extension; // Se utiliza solo el nombre de usuario como nombre de archivo

		// Combinar el nombre del usuario con la extensión del archivo para formar el nombre del archivo de sello
		$sello_destination = 'sellos/' . $nombre_archivo_sello;


		// Manejar la carga del archivo de sello
		if (isset ($_FILES['sello']) && $_FILES['sello']['error'] === UPLOAD_ERR_OK) {
			// Mover el archivo de sello a la carpeta deseada con el nuevo nombre
			if (move_uploaded_file($sello_tmp_name, $sello_destination)) {
				// Guardar la ruta del sello en la base de datos
				$users = new user_model();
				$users->modificar($id, $tipo_user, $usuario, $password, $sello_destination);
			} else {
				echo "Error al mover el archivo de sello.";
				// Puedes redirigir o mostrar un mensaje de error apropiado
				return;
			}
		} else {
			$users = new user_model();
			$users->modificar($id, $tipo_user, $usuario, $password, null);
		}

		$data["titulo"] = "Usuarios";
		header("Location: home.php?c=users&a=index");
        exit(); 
	}

	public function eliminar($id)
	{

		$users = new user_model();
		$users->eliminar($id);
		$data["titulo"] = "Usuarios";
		header("Location: home.php?c=users&a=index");
        exit(); 
	}

}
?>