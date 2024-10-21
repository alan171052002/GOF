<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAMTO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
      
      
      <?php
	require_once "home.php";
	require_once "config/config.php";
	require_once "core/routes.php";
	require_once "config/database.php";
	require_once "controller/users.php";
	require_once "controller/login.php";
	require_once "views/login/login.php";
	require_once "portails/head.php";
	require_once "controller/sesion.php";
	require_once "controller/facturas.php";
	require_once 'vendor/autoload.php';


	if(isset($_GET['c'])){
		
		$controlador = cargarControlador($_GET['c']);
		
		if(isset($_GET['a'])){
			if(isset($_GET['id'])){
				cargarAccion($controlador, $_GET['a'], $_GET['id']);
				} else {
				cargarAccion($controlador, $_GET['a']);
			}
			} else {
			cargarAccion($controlador, ACCION_PRINCIPAL);
		}
		
		} else {
		
		$controlador = cargarControlador(CONTROLADOR_PRINCIPAL);
		$accionTmp = ACCION_PRINCIPAL;
		$controlador->$accionTmp();
	}
?>


</html>

