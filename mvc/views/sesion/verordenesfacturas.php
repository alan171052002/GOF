<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $data["titulo"]; ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h2 class="display-6">
            <?= $data["titulo"]; ?>
        </h2>
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Número de Factura</th>
                        <th>Fecha</th>
                        <th>PDF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data["facturasasociadas"] as $factura): ?>
                        <tr>
                            <td>
                                <?= $factura["numero_factura"]; ?>
                            </td>
                            <td>
                                <?= $factura["fecha_factura"]; ?>
                            </td>
                            <td>
                                <button onclick="openModelPDF('<?php echo $factura['pdf_factura'] ?>')"
                                    class="btn btn-outline-danger" type="button">Ver Factura</button>
                            </td>
                            <!-- Enlace para descargar el PDF 
                            <a href="<?= $factura["pdf_factura"]; ?>" target="_blank">
                                <?= $factura["pdf_factura"]; ?>
                            </a>-->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="home.php?c=sesion&a=index" class="btn btn-secondary">Volver</a>
    </div>
    <div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdf" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Orden de compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <iframe id="iframePDF" frameborder="0" scrolling="no" width="100%" height="750px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <h1></h1>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script>
        function openModelPDF(pdf) {
            $('#modalPdf').modal('show');
            $('#iframePDF').attr('src', '<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/HTML/mvc/'; ?>' + pdf);
                
        }
    </script>
</body>

</html>