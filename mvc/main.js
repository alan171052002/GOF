document.querySelectorAll('.agregarSelloBtn').forEach(function (button) {
    button.addEventListener('click', async function (event) {
        const pdfUrl = button.parentElement.querySelector('.pdfUrl').value;
        const numOrden = button.dataset.numeroOrden;

        if (!pdfUrl) {
            alert('No se ha proporcionado una URL de PDF');
            return;
        }

        const response = await fetch(pdfUrl);
        const pdfBytes = await response.arrayBuffer();
        const pdfDoc = await PDFLib.PDFDocument.load(pdfBytes);

        // Cargar la imagen desde la ruta (cambia "logo.png" por la ruta a tu imagen)
        const imageResponse = await fetch("logo.png");
        const imageBytes = await imageResponse.arrayBuffer();
        const image = await pdfDoc.embedPng(imageBytes);
        const firstPage = pdfDoc.getPages()[0];

        // Ajustar el tamaño de la imagen al 3% de su escala original
        const { width, height } = image.scale(0.03);

        // Dibujar la imagen en el PDF
        firstPage.drawImage(image, {
            x: 20,
            y: 28,
            width,
            height,
        });

        const modifiedPdfBytes = await pdfDoc.save();

        // Descargar el nuevo PDF con el nombre num_orden.pdf
        const blob = new Blob([modifiedPdfBytes], { type: 'application/pdf' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = numOrden + '.pdf';
        link.click();
    });
});