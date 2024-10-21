<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asociar Orden de Compra</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <h2 class="display-3">Asociar Factura de Compra</h2>
        <form action="home.php?c=facturas&a=asociarOrdenFactura" method="post">
            <div class="mb-3">
                <input type="hidden" id="num_factura" name="num_factura" value="<?php echo $data["num_factura"]; ?>" />
                <div class="form-group">
                    <label for="Nombre">
                        <h2 class="display-5">
                            Factura No: <?php echo $data["num_factura"]; ?>
                        </h2>
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <h2 class="labelo">Seleccione las Órdenes de Compra:</h2>
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="num_orden">

                    <?php foreach ($data["orden"] as $orden): ?>
                        <option selected>Selecciona la orden de Compra</option>
                        <option value="<?= $orden['num_orden'] ?>">
                            <?= $orden['num_orden'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Asociar</button>
            <a href="home.php?c=facturas&a=index" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>