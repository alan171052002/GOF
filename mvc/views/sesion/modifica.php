<?php

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAMTO</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="javascript.js"></script>

</head>

<body>
    <div class="container">

        <h2 class="display-3">
            <?php echo $data["titulo"]; ?>:
        </h2>

        <form id="nuevo" name="nuevo" method="POST" action="home.php?c=sesion&a=actualizar" autocomplete="off"
            enctype="multipart/form-data">
            <input type="hidden" id="num_orden" name="num_orden" value="<?php echo $data["num_orden"]; ?>" class="labelo"/>
            <div class="form-group">
                <label for="Nombre">
                    <h3>
                        OC <?php echo $data["num_orden"]; ?>
                    </h3>
                </label>
            </div>


            <div class="form-group">
                <label for="departamento" class="labelo">Departamento</label>
                <select class="form-control" id="departamento" name="departamento">
                    <option value=""></option>
                    <option value="Compras">Compras</option>
                    <option value="Usuarios">Usuarios</option>
                    <option value="Almacen">Almacén</option>
                    <option value="Almacen Materia Prima">Almacén Materia Prima</option>
                    <option value="Almacen Herramientas">Almacén Herramientas</option>
                    <option value="Calidad">Calidad</option>
                </select>
            </div>
            <div class="form-group">
                <label for="observaciones" class="labelo">Observaciones</label>
                <input type="text" class="form-control" id="observaciones" name="observaciones" />
            </div>
            <?php if ($tipo_usuario === 'admin' || $tipo_usuario === 'Compras'): ?>
            <div class="form-group">
                <label for="departamento" class="labelo">Estado</label>
                <select class="form-control" id="estado" name="estado">
                    <option value=""></option>
                    <option value="Activo">Activo</option>
                    <option value="Terminado">Terminado</option>
                </select>
            </div>
            <?php
        endif; ?>
        <?php if ($tipo_usuario === 'Almacen Herramientas' 
                        || $tipo_usuario === 'Almacen Materia Prima' 
                        || $tipo_usuario === 'Almacen'
                        || $tipo_usuario === 'Calidad'
                        || $tipo_usuario === 'Usuarios'): ?>
            <div class="form-group">
                <label for="departamento" class="labelo">Estado</label>
                <select class="form-control" id="estado" name="estado">
                    <option value="Activo">Activo</option>
                </select>
            </div>
            <?php
        endif; ?>
            <div class="form-group">
                <label for="pdf" class="labelo">PDF</label>
                <input class="form-control" type="file" id="pdf" name="pdf" accept="application/pdf" />
            </div><br>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button id="guardar" name="guardar" type="submit" class="btn btn-dark" >Guardar</button>
            </div>
        </form>
        <div class="d-grid gap-2 col-6 mx-auto"><br>
            <a href="home.php?c=sesion&a=index" class="btn btn-secondary">
                Regresar
            </a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('nuevo');

            form.addEventListener('submit', function (event) {
                var depaValue = document.getElementById('departamento').value.trim();
                var pdfValue = document.getElementById('pdf').value.trim();

                if (depaValue.length === 0 || pdfValue.length < 8) {
                    alert('Por favor, asegúrate de que todos los campos cumplen con los requisitos de longitud.');
                    event.preventDefault();
                } else {
                    // Deshabilita el botón después de enviar el formulario
                    document.getElementById('guardar').disabled = true;
                }
            });
        });
    </script>
</body>

</html>