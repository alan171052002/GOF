<?php
// Verifica si el usuario ha iniciado sesión
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';
$isCompras = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Compras';
$isUsuario = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Usuarios';
$isalmacen = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Almacen';
$isalmacen2 = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Almacen Herramientas';
$isalmacen3 = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'Almacen Materia Prima';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="\HTML\mvc\styles2.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G.O.F</title>

</head>

<body>


    <div class="barra-lateral">
        <div class="nombre-pagina">
            <ion-icon id="persona" name="accessibility-outline"></ion-icon>
            <span><img src="logo.png"></span>
        </div>
        <?php if ($isLoggedIn): ?>
            <?php
            // Obtener el nombre del usuario y el usuario desde la sesión
            $nombreUsuario = isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : '';
            $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
            $departamento = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : '';
            $sello = isset($_SESSION['sello']) ? $_SESSION['sello'] : '';

            ?>
            <a href="views/login/logout.php" class="boton">
                <ion-icon name="person-add-outline"></ion-icon>
                <span>Cerrar Sesión</span>
            </a>
        <?php else: ?>
            <a href="home.php?c=login&a=index" class="boton">
                <ion-icon name="person-add-outline"></ion-icon>
                <span>Iniciar Sesión</span>
            <?php endif; ?>
        </a>
        <nav class="navegacion">
            <ul>
                <?php if ($isAdmin): ?>
                    <li>
                        <a href="home.php?c=users&a=index">
                            <ion-icon name="people-sharp"></ion-icon>
                            <span>Usuarios</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($isLoggedIn): ?>
                    <li>
                        <a href="home.php?c=sesion&a=index">
                            <ion-icon name="document-attach-sharp"></ion-icon>
                            <span>Ordenes de<br> Compra</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($isAdmin || $isCompras || $isUsuario || $isalmacen || $isalmacen2 || $isalmacen3): ?>
                    <li>
                        <a href="home.php?c=facturas&a=index">
                            <ion-icon name="wallet-sharp"></ion-icon>
                            <span>Facturas</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        </nav>
        <div class="linea"></div>
        <?php if ($isLoggedIn): ?>
            <div class="usuario">
                <img src="<?= $sello; ?>">
                <div class="info-usuario">
                    <div class="nombre-departamento">
                        <span class="nombre">Bienvenido <br><?= $nombreUsuario ?><br></span>
                        <span class="departamento"><?= $departamento ?></span>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="\HTML\mvc\script.js"></script>
</body>

</html>