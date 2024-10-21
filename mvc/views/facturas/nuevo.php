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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="javascript.js"></script>
</head>

<body>
    <div class="container">
        <h2 class="display-3">
            <?php echo $data["titulo"]; ?>
        </h2>

        <form id="nuevo" name="nuevo" method="POST" action="home.php?c=facturas&a=guarda" autocomplete="off"
            onsubmit="return validarFormulario()" enctype="multipart/form-data">

            <div class="form-group">
                <label for="num_factura">Numero de Factura</label>
                <input type="text" class="form-control" id="num_factura" name="num_factura" />
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input class="form-control" type="date" id="fecha" name="fecha" />
                
            </div>

            <div class="form-group">
                <label for="parcialidades">Parcialidades</label>
                <input type="text" class="form-control" id="parcialidades" name="parcialidades" />
                
            </div>
            <div class="form-group">
                <label for="pdf">PDF</label>
                <input class="form-control" type="file" id="pdf" name="pdf" accept="application/pdf" />
            </div><br>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button id="guardar" name="guardar" type="submit" class="btn btn-outline-success">Guardar</button>
            </div>
        </form><br>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a href="home.php?c=factura&a=index" class="btn btn-secondary">
                Regresa
            </a>
        </div>

    </div>

    <script>
        function validarFormulario() {
            var num_factura = document.getElementById("num_factura").value;
            var fecha = document.getElementById("fecha").value;
            var parcialidades = document.getElementById("parcialidades").value;

            if (num_factura.trim() === "" || fecha.trim() === "" || parcialidades.trim() === "") {
                alert("Ningún campo puede quedar en blanco.");
                return false;
            }

            if (num_factura.length < 5) {
                alert("El numero de Factura debe tener al menos 5 caracteres.");
                return false;
            }
            if (pdf === null) {
                alert("Se debe subir el docuemnto")
            }

            return true;
        }
    </script>
</body>

</html>