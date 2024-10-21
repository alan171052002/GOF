<?php

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EliDeli Botanas</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="javascript.js"></script>

</head>

<body>
    <div class="container">

        <h2>
            <?php echo $data["titulo"]; ?> 
            
        </h2>
        <br>
        <form id="nuevo" name="nuevo" method="POST" action="home.php?c=users&a=actualizar" autocomplete="off"
            enctype="multipart/form-data">

            <input type="hidden" id="id" name="id" value="<?php echo $data["id"]; ?>" />

            <div class="form-group">
                <label for="Nombre" class="labelo">Nombre de Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" />
            </div>
            <div class="select-container">
                <label for="tipo_user" class="labelo">Tipo de usuario</label>
                <select class="form-control" id="tipo_user" name="tipo_user">
                    <option value=""></option>
                    <option value="Compras">Compras</option>
                    <option value="Usuarios">Usuarios</option>
                    <option value="Almacen">Almacén</option>
                    <option value="Almacen Materia Prima">Almacén Materia Prima</option>
                    <option value="Almacen Herramientas">Almacén Herramientas</option>
                    <option value="Calidad">Calidad</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password" class="labelo">Password</label>
                <input class="form-control" id="password" name="password" type="password" />
            </div>
            <div class="form-group">
                <label class="labelo" for="sello">Sello</label>
                <input type="file" class="form-control" id="sello" name="sello" accept="application/image"
                    onchange="previewImage(this)" />
                <img id="preview" src="#" alt="Vista previa de la imagen"
                    style="max-width: 200px; max-height: 200px; display: none;" />
                <!-- Esta etiqueta img mostrará la vista previa de la imagen seleccionada -->
            </div><br>
            <div class="d-grid gap-2 col-6 mx-auto">

                <button id="guardar" name="guardar" type="submit" class="btn btn-dark">Guardar</button>
            </div><br>
                
        </form>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a href="home.php?c=users&a=index" name="regreso" type="submit" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
    <script>
        // Función para mostrar la vista previa de la imagen seleccionada
        function previewImage(input) {
            var preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.style.display = 'block'; // Mostrar la vista previa
                    preview.src = e.target.result; // Mostrar la imagen seleccionada
                }
                reader.readAsDataURL(input.files[0]); // Leer el archivo de imagen como una URL
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('nuevo');

            form.addEventListener('submit', function (event) {
                var nombreValue = document.getElementById('Nombre').value.trim();
                var usuarioValue = document.getElementById('usuario').value.trim();
                var tipoUserValue = document.getElementById('tipo_user').value.trim();
                var passwordValue = document.getElementById('password').value.trim();

                if (nombreValue.length === 0 || usuarioValue.length < 8 || tipoUserValue.length === 0 || passwordValue.length < 8) {
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