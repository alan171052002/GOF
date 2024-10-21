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
        <form action="home.php?c=sesion&a=buscar" method="POST" class="mb-3" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar por número de orden..." name="num_orden">
                <button class="btn btn-info" type="buttom">Buscar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered border border-3 border-ligth">
                <thead class="table-light">
                    <tr>
                        <th>Numero de orden</th>
                        <th>Departamento</th>
                        <?php if ($tipo_usuario !== 'Calidad'): ?>
                        <th>Observaciones</th>
                        <?php
                                endif; ?>

                        <th></th>
                        <?php if ($tipo_usuario === 'admin'): ?>
                            <?php
                        endif; ?>
                        <th>PDF</th>
                        <?php if ($tipo_usuario === 'admin' || $tipo_usuario === 'Compras'): ?>
                            <th>Facturas</th>
                            <th>Estado</th>
                            <?php
                        endif; ?>
                        <?php if ($tipo_usuario === 'Almacen Herramientas' 
                        || $tipo_usuario === 'Almacen Materia Prima' 
                        || $tipo_usuario === 'Almacen'): ?>
                            <th></th>
                            <th></th>
                            <?php
                        endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data["orden"] as $dato): ?>
                        <?php
                        // Verificar si el usuario actual puede ver esta orden
                        $puedeVerOrden = false;
                        if ($tipo_usuario === 'admin' && $dato["estado"] === 'Terminado') {
                            $puedeVerOrden = true; // El administrador puede ver todas las órdenes
                        } elseif ($tipo_usuario === 'Compras' && $dato["departamento"] === 'Compras' && $dato["estado"] === 'Terminado') {
                            $puedeVerOrden = true; // El usuario de compras solo puede ver las órdenes de compras
                        } elseif ($tipo_usuario === 'Almacen' && $dato["departamento"] === 'Almacen' ) {
                            $puedeVerOrden = true; // El usuario de almacén solo puede ver las órdenes de almacén
                        } elseif ($tipo_usuario === 'Almacen Materia Prima' && $dato["departamento"] === 'Almacen Materia Prima') {
                            $puedeVerOrden = true; // El usuario de almacén solo puede ver las órdenes de almacén Materia Prima
                        } elseif ($tipo_usuario === 'Almacen Herramientas' && $dato["departamento"] === 'Almacen Herramientas') {
                            $puedeVerOrden = true; // El usuario de almacén solo puede ver las órdenes de almacén erramientas
                        } elseif ($tipo_usuario === 'Usuarios' && $dato["departamento"] === 'Usuarios') {
                            $puedeVerOrden = true; // El usuario de almacén solo puede ver las órdenes de almacén
                        } elseif ($tipo_usuario === 'Calidad' && $dato["departamento"] === 'Calidad') {
                            $puedeVerOrden = true; // El usuario de almacén solo puede ver las órdenes de almacén
                        }

                        // Si el usuario no puede ver la orden, pasar a la siguiente iteración del bucle
                        if (!$puedeVerOrden) {
                            continue;
                        }
                        ?>
                        <tr>
                            <td>
                                <?= $dato["num_orden"]; ?>
                            </td>
                            <td>
                                <?= $dato["departamento"]; ?>
                            </td>
                            <?php if ($tipo_usuario !== 'Calidad'): ?>
                            <td>
                                <?= $dato["observaciones"]; ?>
                            </td>
                            <?php
                                endif; ?>
                            <td>
                                <?php if ($tipo_usuario === 'admin'): ?>
                                    <a href='home.php?c=sesion&a=eliminar&id=<?= $dato["num_orden"]; ?>'
                                        class='btn btn-danger btn-action'>Eliminar</a>
                                </td>
                                <?php
                                endif; ?>
                            <td>
                                <form class="d-flex">
                                    <input type="hidden" class="pdfUrl" value="<?= $dato["pdf"]; ?>" />
                                    <button onclick="openModelPDF('<?php echo $dato['pdf'] ?>')"
                                    class="btn btn-outline-info" type="button">Ver Orden</button>
                                   
                            </td>
                            <?php if ($tipo_usuario === 'admin' || $tipo_usuario === 'Compras'): ?>
                            <td>
                                    <a class="btn btn-outline-warning" type="submit"
                                        href="home.php?c=facturas&a=paginavero&id=<?= $dato["num_orden"]; ?>">Ver Facturas</a>
                                    <form action="home.php?c=facturas&a=paginaasociaro&id=<?= $dato["num_orden"]; ?>"
                                        method="post">
                                        <button type="submit" class="btn btn-outline-info">Asociar OC</button>
                                    </form>
                                </td>
                                <?php
                                endif; ?>
                                <td>
                                    <?= $dato["estado"]; ?>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($data["current_page"] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="home.php?c=sesion&a=index2&p=<?= $data["current_page"] - 1; ?>"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $data["total_pages"]; $i++): ?>
                    <li class="page-item <?= $i == $data["current_page"] ? 'active' : ''; ?>">
                        <a class="page-link" href="home.php?c=sesion&a=index2&p=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($data["current_page"] < $data["total_pages"]): ?>
                    <li class="page-item">
                        <a class="page-link" href="home.php?c=sesion&a=index2&p=<?= $data["current_page"] + 1; ?>"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>


        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="home.php?c=sesion&a=index" class="btn btn-danger btn-action">Regresar</a>
        </div>
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
                case 'Usuarios':
                    return { x: 465, y: 42 }; // Coordenadas para departamento Usuarios
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
                        color: PDFLib.rgb(1, 1, 1), // Color de fondo del cuadrado
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
                        color: PDFLib.rgb(1, 1, 1), // Color de fondo del cuadrado
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
                        color: PDFLib.rgb(1, 1, 1), // Color de fondo del cuadrado
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

                if (departamento === 'Calidad') {

                    coordenadasSello;
                    const totalPages = pdfDoc.getPageCount();
                    let img;
                    if (calidad === "no_conforme") {
                        img = "NO_conforme";
                    } else {
                        img = "Conforme";
                    }
                    const selloImagenUrl = 'sellos/' + img + '.png';
                    const imageResponse = await fetch(selloImagenUrl);
                    const imageBytes = await imageResponse.arrayBuffer();
                    const image = await pdfDoc.embedPng(imageBytes);

                    for (let i = 0; i < totalPages; i++) {
                        if (i % 2 === 1) {
                            continue;
                        }

                        const page = pdfDoc.getPage(i);
                        const { width, height } = image.scale(0.28);

                        page.drawImage(image, {
                            x: coordenadasSello.x,
                            y: coordenadasSello.y,
                            width,
                            height,
                        });
                    }
                    // Cargar la imagen del sello desde la ruta correspondiente
                    // Coordenadas para departamento Calidad

                }
                console.log(coordenadasSello);



                <?php
                $departamento = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : '';
                ?>
                if (departamento !== 'Almacen' && departamento !== 'Calidad' && departamento !== 'Almacen Herramientas' && departamento !== 'Almacen Materia Prima') {
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






</html>