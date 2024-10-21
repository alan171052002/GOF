<?php
// Verifica si el usuario ha iniciado sesión
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';
$isCompras = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Compras';
?>

<header>
    
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="logo.png" alt="" width="120" height="80" class="d-inline-block align-text-top">
            </a>

            <?php if ($isLoggedIn): ?>
                <?php
                // Obtener el nombre del usuario y el usuario desde la sesión
                $nombreUsuario = isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : '';
                $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
                $departamento = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : '';
                ?>
                <span class="user-name">
                    Bienvenido
                    <?= $nombreUsuario ?><br>
                    Usuario:
                    <?= $usuario ?><br>
                </span>

                <div class="navbar-text">

                    <?php if ($isAdmin): ?>
                        <a href="home.php?c=users&a=index" class="btn btn-outline-warning">Usuarios</a>
                    <?php endif; ?>
                    <a href="home.php?c=sesion&a=index" class="btn btn-outline-info">Ordenes de Compra</a>
                    <?php if ($isAdmin || $isCompras): ?>
                        <a href="home.php?c=facturas&a=index" class="btn btn-outline-info">Facturas</a>
                    <?php endif; ?>
                    <a href="views/login/logout.php" class="btn btn-outline-danger">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="home.php?c=login&a=index" class="btn btn-outline-dark">Iniciar Sesión</a>
                <?php endif; ?>

            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.17.0/dist/pdf-lib.js"></script>
    <link rel="stylesheet" href="\HTML\mvc\style.css">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <nav class="navbar navbar-light" style="background-color: #e3f2fd;"></nav>
</header>