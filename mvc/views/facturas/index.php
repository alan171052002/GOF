<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de compra</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de incluir tu propio archivo de estilo si es necesario -->


</head>

<body>
    <div class="container">
        <h2 class="display-3">
            <?= $data["titulo"]; ?>
        </h2>

        <form action="home.php?c=facturas&a=buscar" method="POST" class="mb-3" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar por número de factura..."
                    name="num_factura">
                <button class="btn btn-info" type="buttom">Buscar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered border border-3 border-ligth">
                <thead class="table-light">
                    <tr>
                        <th>Numero de Factura</th>
                        <th>Fecha</th>
                        <th>Parcialidades</th>

                        <th></th>
                        <?php if ($tipo_usuario === 'admin' || $tipo_usuario === 'Compras'): ?>
                            <th></th>
                            <?php
                        endif; ?>
                        <?php if (
                            $tipo_usuario === 'Ususario'
                            || $tipo_usuario === 'Almacen'
                            || $tipo_usuario === 'Almacen Herramientas'
                            || $tipo_usuario === 'Almacen Materia Prima'
                        ): ?>
                            <th></th>
                            <?php
                        endif; ?>
                        <th>Ordenes de Compra</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data["facturas"] as $dato): ?>
                        <?php if (
                            $tipo_usuario === 'admin' || $tipo_usuario === 'Compras'
                            || $tipo_usuario === 'Usuarios'
                            || $tipo_usuario === 'Almacen'
                            || $tipo_usuario === 'Almacen Herramientas'
                            || $tipo_usuario === 'Almacen Materia Prima'
                        ): ?>
                            <tr>
                                <td>
                                    <?= $dato["num_factura"]; ?>
                                </td>
                                <td>
                                    <?= $dato["fecha"]; ?>
                                </td>
                                <td>
                                    <?= $dato["parcialidades"]; ?>
                                </td>

                                <td><a href='home.php?c=facturas&a=modificar&id=<?= $dato["num_factura"]; ?>'
                                        class='btn btn-warning btn-action'>Actualizar</a>
                                    <?php if ($tipo_usuario === 'admin' || $tipo_usuario === 'Compras'): ?>
                                        <a href='home.php?c=facturas&a=eliminar&id=<?= $dato["num_factura"]; ?>'
                                            class='btn btn-danger btn-action'>Eliminar</a>
                                    </td>
                                    <?php
                                    endif; ?>
                                <form class="d-flex">
                                    <input type="hidden" class="pdfUrl" value="<?= $dato["pdf"]; ?>" />
                                </form>
                                <td>
                                    <?php if ($dato['pdf'] !== null): ?>
                                        <input type="hidden" class="pdfUrl" value="<?= $dato["pdf"]; ?>" />
                                        <button onclick="openModelPDF('<?php echo $dato['pdf'] ?>')" class="btn btn-outline-danger"
                                            type="button">Ver Factura</button>
                                        <button type="button" class="btn btn-outline-success agregarSelloBtn"
                                            data-numero-orden="<?= $dato["num_factura"]; ?>"
                                            data-departamento="<?= $tipo_usuario; ?>">Agregar
                                            sello</button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a class="btn btn-outline-warning" type="submit"
                                        href="home.php?c=facturas&a=paginaverf&id=<?= $dato["num_factura"]; ?>">Ver Ordenes</a>
                                    <form action="home.php?c=facturas&a=paginaasociar&id=<?= $dato["num_factura"]; ?>"
                                        method="post"><?php if (
                                            $tipo_usuario === 'Compras'
                                            || $tipo_usuario === 'admin'
                                        ): ?>
                                            <button type="submit" class="btn btn-outline-info">Asociar Fact</button>
                                            <?php
                                        endif; ?>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <?php if (
                $tipo_usuario === 'Compras'
                || $tipo_usuario === 'admin'
            ): ?>
                <a href="home.php?c=facturas&a=nuevo" class="btn btn-success btn-action">Agregar</a>
                <?php
            endif; ?>
            <a href="index.php" class="btn btn-danger btn-action">Regresar</a>
        </div>
    </div>
    <div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdf" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Factura de compra</h5>
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
    <script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.16.0/dist/pdf-lib.js"></script>

    <script>
        // Verifica el tipo de usuario y establece las coordenadas del sello según el departamento
        // Función para obtener las coordenadas del sello según el departamento
        function obtenerCoordenadasSello(departamento) {
            switch (departamento) {
                case 'admin':
                    return { x: 12.5, y: 70 }; // Coordenadas para departamento admin
                case 'Compras':
                    return { x: 115, y: 64 }; // Coordenadas para departamento Compras
                case 'Calidad':
                    return { x: 325, y: 42 }; // Coordenadas para departamento Calidad
            }
        }
        // Función para agregar el evento click a los botones "Agregar sello"
        document.querySelectorAll('.agregarSelloBtn').forEach(function (button) {
            button.addEventListener('click', async function (event) {
                const pdfUrl = button.parentElement.querySelector('.pdfUrl').value;
                const numOrden = button.dataset.numeroOrden;
                const departamento = button.dataset.departamento;
                const calidad = button.dataset.calidad
                console.log('Departamento:', departamento);

                if (!pdfUrl) {
                    alert('No se ha proporcionado una URL de PDF');
                    return;
                }

                const response = await fetch(pdfUrl);
                const pdfBytes = await response.arrayBuffer();
                const pdfDoc = await PDFLib.PDFDocument.load(pdfBytes);

                // Definir las coordenadas del sello
                const coordenadasSello = obtenerCoordenadasSello(departamento);

                if (departamento === 'Almacen') {

                    const currentDate = new Date().toLocaleDateString('es-ES');
                    // Agregar el texto "Recibido Almacén" y la fecha en la primera página
                    const firstPage = pdfDoc.getPages()[0];

                    // Definir las coordenadas y el tamaño del cuadrado
                    const squareX = 320;
                    const squareY = 270;
                    const squareWidth = 200;
                    const squareHeight = 90;

                    // Dibujar el cuadrado
                    firstPage.drawRectangle({
                        x: squareX,
                        y: squareY,
                        width: squareWidth,
                        height: squareHeight,
                        borderColor: PDFLib.rgb(0, 0, 0), // Color del borde del cuadrado
                        borderWidth: 2, // Ancho del borde
                        color: undefined // Color de fondo del cuadrado
                    });
                    <?php
                    $nombreUsuario = isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : '';
                    ?>

                    // Agregar el texto "Recibido Almacén" dentro del cuadrado
                    firstPage.drawText(`Industrial Tamto de Puebla`, {
                        x: squareX + 10,
                        y: squareY + squareHeight - 10,
                        size: 10,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });
                    firstPage.drawText('Recibido en Almacén\nPor: <?php echo $nombreUsuario ?>', {
                        x: squareX + 10,
                        y: squareY + squareHeight - 20,
                        size: 18,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                    // Agregar la fecha dentro del cuadrado
                    firstPage.drawText(`Fecha: ${currentDate}`, {
                        x: squareX + 10,
                        y: squareY + squareHeight - 70,
                        size: 14,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                }
                if (departamento == 'Almacen Materia Prima') {

                    const currentDate = new Date().toLocaleDateString('es-ES');
                    // Agregar el texto "Recibido Almacén" y la fecha en la primera página
                    const firstPage = pdfDoc.getPages()[0];

                    // Definir las coordenadas y el tamaño del cuadrado
                    const squareX = 320;
                    const squareY = 270;
                    const squareWidth = 200;
                    const squareHeight = 90;

                    // Dibujar el cuadrado
                    firstPage.drawRectangle({
                        x: squareX,
                        y: squareY,
                        width: squareWidth,
                        height: squareHeight,
                        borderColor: PDFLib.rgb(0, 0, 0), // Color del borde del cuadrado
                        borderWidth: 2, // Ancho del borde
                        color: undefined, // Color de fondo del cuadrado
                    });
                    <?php
                    $nombreUsuario = isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : '';
                    ?>
                    firstPage.drawText(`Industrial Tamto de Puebla`, {
                        x: squareX + 10,
                        y: squareY + squareHeight - 10,
                        size: 10,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                    // Agregar el texto "Recibido Almacén" dentro del cuadrado
                    firstPage.drawText('Recibido en Almacén\nPor: <?php echo $nombreUsuario ?>', {
                        x: squareX + 10,
                        y: squareY + squareHeight - 20,
                        size: 18,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                    // Agregar la fecha dentro del cuadrado
                    firstPage.drawText(`Fecha: ${currentDate}`, {
                        x: squareX + 10,
                        y: squareY + squareHeight - 70,
                        size: 14,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                }
                if (departamento === 'Almacen Herramientas') {

                    const currentDate = new Date().toLocaleDateString('es-ES');
                    // Agregar el texto "Recibido Almacén" y la fecha en la primera página
                    const firstPage = pdfDoc.getPages()[0];

                    // Definir las coordenadas y el tamaño del cuadrado
                    const squareX = 320;
                    const squareY = 270;
                    const squareWidth = 200;
                    const squareHeight = 90;

                    // Dibujar el cuadrado
                    firstPage.drawRectangle({
                        x: squareX,
                        y: squareY,
                        width: squareWidth,
                        height: squareHeight,
                        borderColor: PDFLib.rgb(0, 0, 0), // Color del borde del cuadrado
                        borderWidth: 2, // Ancho del borde
                        color: undefined, // Color de fondo del cuadrado
                    });
                    firstPage.drawText(`Industrial Tamto de Puebla`, {
                        x: squareX + 10,
                        y: squareY + squareHeight - 10,
                        size: 10,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });
                    <?php
                    $nombreUsuario = isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : '';
                    ?>

                    // Agregar el texto "Recibido Almacén" dentro del cuadrado
                    firstPage.drawText('Recibido en Almacén\nPor: <?php echo $nombreUsuario ?>', {
                        x: squareX + 10,
                        y: squareY + squareHeight - 30,
                        size: 18,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                    // Agregar la fecha dentro del cuadrado
                    firstPage.drawText(`Fecha: ${currentDate}`, {
                        x: squareX + 10,
                        y: squareY + squareHeight - 70,
                        size: 14,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                }
                if (departamento === 'Usuarios') {

                    const currentDate = new Date().toLocaleDateString('es-ES');
                    // Agregar el texto "Recibido Almacén" y la fecha en la primera página
                    const firstPage = pdfDoc.getPages()[0];

                    // Definir las coordenadas y el tamaño del cuadrado
                    const squareX = 320;
                    const squareY = 270;
                    const squareWidth = 200;
                    const squareHeight = 90;

                    // Dibujar el cuadrado
                    firstPage.drawRectangle({
                        x: squareX,
                        y: squareY,
                        width: squareWidth,
                        height: squareHeight,
                        borderColor: PDFLib.rgb(0, 0, 0), // Color del borde del cuadrado
                        borderWidth: 2, // Ancho del borde
                        color: undefined, // Color de fondo del cuadrado
                    });
                    firstPage.drawText(`Industrial Tamto de Puebla`, {
                        x: squareX + 10,
                        y: squareY + squareHeight - 10,
                        size: 10,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });
                    <?php
                    $nombreUsuario = isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : '';
                    ?>

                    // Agregar el texto "Recibido Almacén" dentro del cuadrado
                    firstPage.drawText('Recibido \nPor: <?php echo $nombreUsuario ?>', {
                        x: squareX + 10,
                        y: squareY + squareHeight - 30,
                        size: 18,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                    // Agregar la fecha dentro del cuadrado
                    firstPage.drawText(`Fecha: ${currentDate}`, {
                        x: squareX + 10,
                        y: squareY + squareHeight - 70,
                        size: 14,
                        color: PDFLib.rgb(0, 0, 0), // Color del texto
                    });

                }


                console.log(coordenadasSello);



                <?php
                $departamento = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : '';
                ?>
                if (departamento !== 'Almacen' 
                && departamento !== 'Calidad' && departamento !== 'Almacen Herramientas' 
                && departamento !== 'Almacen Materia Prima'  && departamento !== 'Usuarios') {
                    // Obtener el número total de páginas del PDF
                    const totalPages = pdfDoc.getPageCount();
                    <?php
                    // Obtener el nombre del usuario desde la sesión
                    $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
                    ?>

                    // Cargar la imagen del sello desde la ruta correspondiente
                    const selloImagenUrl = 'sellos/<?php echo $usuario; ?>.png';
                    const imageResponse = await fetch(selloImagenUrl);
                    const imageBytes = await imageResponse.arrayBuffer();
                    const image = await pdfDoc.embedPng(imageBytes);

                    // Iterar sobre las páginas e insertar el sello
                    for (let i = 0; i < totalPages; i++) {
                        if (i % 2 === 1) { // Verificar si el índice de la página es impar
                            continue; // Si la página es par, pasar a la siguiente iteración
                        }

                        const page = pdfDoc.getPage(i);

                        // Ajustar el tamaño de la imagen al 50% de su escala original
                        const { width, height } = image.scale(0.30);

                        // Dibujar la imagen en la página actual utilizando las coordenadas del departamento
                        page.drawImage(image, {
                            x: coordenadasSello.x,
                            y: coordenadasSello.y,
                            width,
                            height,
                        });
                    }
                }

                const modifiedPdfBytes = await pdfDoc.save();

                // Descargar el nuevo PDF con el nombre num_orden.pdf
                const blob = new Blob([modifiedPdfBytes], { type: 'application/pdf' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = numOrden + '.pdf';
                link.click();
            });
        });
    </script>
</body>

</html>