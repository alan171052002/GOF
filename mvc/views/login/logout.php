<?php
session_start();
session_destroy();
// Redirige a la página de inicio u otra página después de cerrar sesión
header("Location: \HTML\mvc\index.php");
exit();
?>
