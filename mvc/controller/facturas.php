<?php
class FacturasController
{
    public function __construct()
    {
        require_once "models/FacturaModel.php";
        require_once "models/OCmodel.php";
        require_once "controller/users.php";
        require_once "controller/sesion.php";

    }

    public function index()
    {
        $OCmodel = new OC_model();
        $facturasModel = new FacturaModel();
        $data["titulo"] = "Facturas";
        $data["facturas"] = $facturasModel->getFacturas();
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $data["orden"] = $OCmodel->get_orders();

        require_once "views/facturas/index.php";
    }

    public function nuevo()
    {
        // Verificar si el usuario tiene permisos para acceder a esta función
        if (!(isset($_SESSION['user_id']) && isset($_SESSION['tipo_usuario']) && ($_SESSION['tipo_usuario'] === 'admin' || $_SESSION['tipo_usuario'] === 'Compras'))) {
            // Si el usuario no está autenticado o no es administrador o comprador, redirigir a la página de inicio de sesión o mostrar un mensaje de error
            header('Location: \HTML\mvc\index.php');
            exit; // Asegura que el script se detenga después de redirigir
        }
        $data["titulo"] = "Nueva Factura";
        require_once "views/facturas/nuevo.php";
    }

    public function guarda()
    {
        // Verificar si el usuario tiene permisos para acceder a esta función
        if (!(isset($_SESSION['user_id']) && isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin')) {
            // Si el usuario no está autenticado o no es administrador, redirigir a la página de inicio de sesión o mostrar un mensaje de error
            header('Location: \HTML\mvc\index.php');
            exit; // Asegura que el script se detenga desp ués de redirigir
        }

        $num_factura = $_POST['num_factura'];
        $fecha = $_POST['fecha'];
        $parcialidades = $_POST['parcialidades'];
        $pdf_destination = ''; // Inicializamos la variable de destino como vacía

        // Verificar si se ha cargado un archivo PDF
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
            $pdf_destination = 'facturas/' . $num_factura . '.pdf';

            // Mover el archivo PDF al directorio deseado
            if (move_uploaded_file($pdf_tmp_name, $pdf_destination)) {
                // Si se ha subido correctamente, guardamos la ruta del PDF en la variable de destino
            } else {
                echo "Error al mover el archivo PDF.";
                // Puedes redirigir o mostrar un mensaje de error apropiado
                return;
            }
        }

        // Guardar la ruta del PDF en la base de datos
        $facturasModel = new FacturaModel();
        if ($facturasModel->existePDF($pdf_destination)) {
            echo "El archivo PDF ya existe en la base de datos.";
            return;
        }
        $facturasModel->insertar($num_factura, $fecha, $parcialidades, $pdf_destination);

        // Redirigir al listado de facturas después de guardar
        header('Location: home.php?c=facturas&a=index');
        exit; // Asegura que el script se detenga después de redirigir
    }

    public function modificar($num_factura)
    {
        // Verificar si el usuario tiene permisos para acceder a esta función
        $fecha = new FacturaModel();

        $data["num_factura"] = $num_factura;
        $data["fecha"] = $fecha->getFactura($num_factura);
        $data["titulo"] = "Factura de compra";

        require_once "views/facturas/modifica.php";
    }

    public function actualizar()
    {
        // Verificar si el usuario tiene permisos para acceder a esta función
        if (!(isset($_SESSION['user_id']))) {
            // Si el usuario no está autenticado o no es administrador, redirigir a la página de inicio de sesión o mostrar un mensaje de error
            header('Location: \HTML\mvc\index.php');
            exit; // Asegura que el script se detenga después de redirigir
        }

        $num_factura = $_POST["num_orden"];
        $fecha = $_POST['departamento'];
        $parcialidades = $_POST['parcialidades'];
        // Manejar la carga del archivo PDF
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
            $pdf_destination = 'facturas/' . $num_factura . '.pdf';

            // Mover el archivo PDF al directorio deseado
            if (move_uploaded_file($pdf_tmp_name, $pdf_destination)) {
                // Guardar la ruta del PDF en la base de datos
                $facturasModel = new FacturaModel();
                $facturasModel->modificar($num_factura, $fecha, $parcialidades, $pdf_destination);
            } else {
                echo "Error al mover el archivo PDF.";
                // Puedes redirigir o mostrar un mensaje de error apropiado
                return;
            }
        } else {
            echo "Error al cargar el archivo PDF.";
            // Puedes redirigir o mostrar un mensaje de error apropiado
            return;
        }
        $data["titulo"] = "Facturas";
        header('Location: home.php?c=facturas&a=index');
    }

    public function eliminar($num_factura)
    {
        // Verificar si el usuario tiene permisos para acceder a esta función
        if (!(isset($_SESSION['user_id']) && isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin')) {
            // Si el usuario no está autenticado o no es administrador, redirigir a la página de inicio de sesión o mostrar un mensaje de error
            header('Location: \HTML\mvc\index.php');
            exit; // Asegura que el script se detenga después de redirigir
        }

        $facturasModel = new FacturaModel();
        $facturasModel->eliminar($num_factura);

        // Después de eliminar, redirigir al listado de facturas
        header('Location: home.php?c=facturas&a=index');
    }
    public function asociarOrdenFactura()
    {
        $num_orden = $_POST['num_orden'];
        $num_factura = $_POST['num_factura'];
        // Asocia una orden de compra a una factura
        $facturasModel = new FacturaModel();
        $facturasModel->asociarOrdenFactura($num_orden, $num_factura);

        // Redirige al usuario a la página de facturas después de asociar la orden a la factura
        header("Location: home.php?c=facturas&a=index");
    }

    public function asociarOrdenes()
    {
        $num_factura = $_POST['num_factura'];
        $ordenes_seleccionadas = $_POST['num_orden'];

        // Lógica para asociar las órdenes de compra a la factura en el modelo
        $facturaModel = new FacturaModel();
        foreach ($ordenes_seleccionadas as $num_orden) {
            $facturaModel->asociarOrdenFactura($num_orden, $num_factura);
        }

        // Redirigir o mostrar un mensaje de éxito
        header("Location: home.php?c=facturas");
        exit;
    }
    public function paginaasociar($num_factura)
    {
        $data["num_factura"] = $num_factura;
        $OCmodel = new OC_model();
        $facturasModel = new FacturaModel();
        $data["titulo"] = "Facturas";
        $data["orden"] = $OCmodel->getOrdenesNoAsociadas($num_factura);
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $data["facturas"] = $facturasModel->getFacturas();
        require_once "views/facturas/asociar.php";
    }
    public function paginaasociaro($num_orden)
    {
        $data["num_orden"] = $num_orden;
        $OCmodel = new OC_model();
        $facturasModel = new FacturaModel();
        $data["titulo"] = "Facturas";
        $data["facturas"] = $facturasModel->getFacturasNoAsociadas($num_orden);
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $data["orden"] = $OCmodel->get_orders();
        require_once "views/sesion/asociar.php";
    }
    public function paginaverf($num_factura)
    {
        $data["num_orden"] = $num_factura;
        $OCmodel = new OC_model();
        $facturasModel = new FacturaModel();
        $facturasasociadas = $facturasModel->getOrdenesAsociadas($num_factura);
        $data["getOrdenesAsociadas"] = $facturasasociadas;
        $data["facturas"] = $facturasModel->getFacturas();
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $data["orden"] = $OCmodel->get_orders();
        $data["titulo"] = "Ordenes Asociadas a la factura: " . $num_factura;
        require_once "views/facturas/verordenesfacturas.php";
    }
    public function paginavero($num_orden)
    {
        $data["num_orden"] = $num_orden;
        $OCmodel = new OC_model();
        $facturasModel = new FacturaModel();
        //$facturasasociadas=$facturasModel->getFacturasAsociadas($num_orden);
        $facturasasociadas = $facturasModel->getFacturasAsociadas($num_orden);
        $data["facturasasociadas"] = $facturasasociadas;
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $data["orden"] = $OCmodel->get_order($num_orden);
        $data["titulo"] = "Facturas Asociadas a la Orden de Compra: " . $num_orden;
        require_once "views/sesion/verordenesfacturas.php";
    }
    public function buscar()
    {
        // Verificar si el usuario tiene permisos para acceder a esta función
        // Coloca aquí la lógica para verificar los permisos del usuario si es necesario

        // Obtener el número de orden a buscar del formulario
        $num_factura = $_POST['num_factura'];


        // Si el número de orden está vacío, redirigir a la página principal
        if (empty($num_factura)) {
            header('Location: home.php?c=facturas&a=index');
            exit;
        }

        // Llamar al modelo para realizar la búsqueda en la base de datos
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $facturasModel = new FacturaModel();
        $data['titulo'] = "Resultados de la búsqueda";
        $data['facturas'] = $facturasModel->buscarPorNumeroOrden($num_factura);


        // Cargar la vista con los resultados de la búsqueda
        require_once "views/facturas/index.php";
    }
    /*public function asociarOrdenFacturaView() {
        $facturasModel = new FacturaModel();
        $data["facturas"] = $facturasModel->getFacturasNoAsociadas();
        // Resto del código para cargar la vista
    }*/
}
?>