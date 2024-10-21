<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAMTO</title>
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de incluir tu propio archivo de estilo si es necesario -->
    <script type="text/javascript" src="javascript.js"></script>

</head>

<body>

    <div class="container">
        <h2 class="display-3">
            <?php echo $data["titulo"]; ?>
        </h2>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered border border-3 border-ligth">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Departamento</th>
                        <th>Sello(s)</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody> 
                    <?php foreach ($data["usuarios"] as $dato): ?>
                        <tr>
                            <td>
                                <?= $dato["Nombre"]; ?>
                            </td>
                            <td>
                                <?= $dato["usuario"]; ?>
                            </td>
                            <td>
                                <?= $dato["tipo_user"]; ?>
                            </td>
                            <td>
                            <img src="<?= $dato["sello"]; ?>" alt="Sello" style="max-width: 100px; max-height: 100px;">
                            </td>
                            <td><a href='home.php?c=users&a=modificar&id=<?= $dato["id"]; ?>'
                                    class='btn btn-warning btn-action'>Modificar</a></td>
                            <td><a href='home.php?c=users&a=eliminar&id=<?= $dato["id"]; ?>'
                                    class='btn btn-danger btn-action'>Eliminar</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div>
            <a href="home.php?c=users&a=nuevo" id="centro" class="btn btn-success btn-action">Agregar</a>
            <a href="index.php" id="centro" class="btn btn-danger btn-action">Regresar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>