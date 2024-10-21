<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tamto</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="javascript.js"></script>
</head>

<body>
    <div class="container">
        <h2 class="display-3">
            <?php echo $data["titulo"]; ?>
        </h2>

        <form id="nuevo" name="nuevo" method="POST" action="home.php?c=users&a=guarda" autocomplete="off"
            onsubmit="return validarFormulario()" enctype="multipart/form-data">

            <div class="form-group">
                <label class="labelo" for="Nombre">Nombre</label>
                <input type="text" class="form-control" id="Nombre" name="Nombre" />
            </div>
            <div class="form-group">
                <label class="labelo" for="tipo_user">Departamento</label>
                <select class="form-control" id="tipo_user" name="tipo_user">
                    <option value="Compras">Compras</option>
                    <option value="Usuarios">Usuarios</option>
                    <option value="Almacen">Almacén</option>
                    <option value="Almacen Materia Prima">Almacén Materia Prima</option>
                    <option value="Almacen Herramientas">Almacén Herramientas</option>
                    <option value="Calidad">Calidad</option>
                </select>
            </div>
            <div class="form-group">
                <label class="labelo" for="usuario">Nombre de usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" />
            </div>

            <div class="form-group">
                <label for="password" class="labelo">Contraseña</label>
                <input class="form-control" type="password" id="password" name="password" />
            </div>
            <div class="form-group">
                <label for="password" class="labelo">Ingresa de nuevo la contraseña</label>
                <input class="form-control" type="password" id="password2" name="password2" />
            </div><br>
            <div class="form-group">
                <label class="labelo" for="sello">Sello</label>
                <input type="file" class="form-control" id="sello" name="sello" accept="application/image" onchange="previewImage(this)" />
                <img id="preview" src="#" alt="Vista previa de la imagen"
                    style="max-width: 200px; max-height: 200px; display: none;" />
                <!-- Esta etiqueta img mostrará la vista previa de la imagen seleccionada -->
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">

                <button id="guardar" name="guardar" type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form><br>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a href="home.php?c=users&a=index" class="btn btn-secondary">
                Regresar
            </a>

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
        function validarFormulario() {
            var nombre = document.getElementById("Nombre").value;
            var tipoUsuario = document.getElementById("tipo_user").value;
            var usuario = document.getElementById("usuario").value;
            var password = document.getElementById("password").value;
            var password2 = document.getElementById("password2").value;

            if (nombre.trim() === "" || tipoUsuario.trim() === "" || usuario.trim() === "" || password.trim() === "" || password2.trim() === "") {
                alert("Ningún campo puede quedar en blanco.");
                return false;
            }

            if (usuario.length < 5) {
                alert("El nombre de usuario debe tener al menos 5 caracteres.");
                return false;
            }

            if (password.length < 8) {
                alert("La contraseña debe tener al menos 8 caracteres.");
                return false;
            }
            if (password !== password2) {
                alert("Las contraseñas deben coincidir");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>