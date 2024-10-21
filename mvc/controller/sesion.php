<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'models/OCmodel.php';
require_once 'controller/users.php';
class sesionController
{

    public function __construct()
    {
        require_once "models/OCmodel.php";
    }


    public function index()
    {
        require_once "models/OCmodel.php";

        // Obtener el número de página actual desde la solicitud GET (por defecto es 1)
        $current_page = isset($_GET['p']) ? intval($_GET['p']) : 1;

        // Número de órdenes por página
        $orders_per_page = 10;

        // Calcular el offset
        $offset = ($current_page - 1) * $orders_per_page;

        // Instanciar el modelo y obtener las órdenes paginadas
        $orders = new OC_model();

        $data["titulo"] = "Ordenes de compra";
        $data["orden"] = $orders->get_orders_paginated($offset, $orders_per_page);

        // Obtener el total de órdenes para calcular el número total de páginas
        $total_orders = $orders->get_total_orders();
        $data["total_pages"] = ceil($total_orders / $orders_per_page);

        // Pasar la página actual a la vista
        $data["current_page"] = $current_page;

        // Tipo de usuario
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $data["tipo_usuario"] = $tipo_usuario;

        // Cargar la vista
        require_once "views/sesion/index.php";
    }

    public function index2()
    {
        require_once "models/OCmodel.php";

        // Obtener el número de página actual desde la solicitud GET (por defecto es 1)
        $current_page = isset($_GET['p']) ? intval($_GET['p']) : 1;

        // Número de órdenes por página
        $orders_per_page = 10;

        // Calcular el offset
        $offset = ($current_page - 1) * $orders_per_page;

        // Instanciar el modelo y obtener las órdenes paginadas
        $orders = new OC_model();

        $data["titulo"] = "Ordenes de compra Cerradas";
        $data["orden"] = $orders->get_orders_paginated($offset, $orders_per_page);

        // Obtener el total de órdenes para calcular el número total de páginas
        $total_orders = $orders->get_total_orders();
        $data["total_pages"] = ceil($total_orders / $orders_per_page);

        // Pasar la página actual a la vista
        $data["current_page"] = $current_page;

        // Tipo de usuario
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $data["tipo_usuario"] = $tipo_usuario;
        // Cargar la vista
        require_once "views/sesion/index2.php";
    }
    public function nuevo()
    {

        $data["titulo"] = "Ordenes de compra";
        require_once "views/sesion/nueva.php";
    }


    public function guarda()
    {
        $num_orden = $_POST['num_orden'];
        $departamento = $_POST['departamento'];
        $observaciones = $_POST['observaciones'];
        $estado = $_POST['estado'];


        // Manejar la carga del archivo PDF
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
            $pdf_destination = 'OC/' . $num_orden . '.pdf';

            // Mover el archivo PDF al directorio deseado
            if (move_uploaded_file($pdf_tmp_name, $pdf_destination)) {
                // Guardar la ruta del PDF en la base de datos
                $orders = new OC_model();
                if ($orders->existePDF($pdf_destination)) {
                    echo "El archivo PDF ya existe en la base de datos.";
                    return;
                }
                $orders->insertar($num_orden, $departamento, $observaciones, $estado, $pdf_destination);
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

        $data["titulo"] = "Ordenes de compra";
        header("Location: home.php?c=sesion&a=index");
        exit();
    }

    public function modificar($num_orden)
    {

        $departamento = new OC_model();

        $data["num_orden"] = $num_orden;
        $data["departamento"] = $departamento->get_order($num_orden);
        $data["titulo"] = "Orden de compra";
        $tipo_usuario = $_SESSION['tipo_usuario'];


        require_once "views/sesion/modifica.php";
    }

    public function actualizar()
    {
        $num_orden = $_POST["num_orden"];
        $departamento = $_POST['departamento'];
        $observaciones = $_POST['observaciones'];
        $estado = $_POST['estado'];
        // Manejar la carga del archivo PDF
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
            $pdf_destination = 'OC/' . $num_orden . '.pdf';

            // Mover el archivo PDF al directorio deseado
            if (move_uploaded_file($pdf_tmp_name, $pdf_destination)) {
                // Guardar la ruta del PDF en la base de datos
                $orders = new OC_model();
                $orders->modificar($num_orden, $departamento, $observaciones, $estado, $pdf_destination);
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
        $data["titulo"] = "departamentos";
        header("Location: home.php?c=sesion&a=index");
        exit();
    }


    public function eliminar($num_orden)
    {

        $orders = new OC_model();
        $orders->eliminar($num_orden);
        $data["titulo"] = "Ordenes de compra";
        $this->index();
    }


    public function buscar()
    {
        // Obtener el número de página actual desde la solicitud GET (por defecto es 1)
        $current_page = isset($_GET['p']) ? intval($_GET['p']) : 1;

        // Número de órdenes por página
        $orders_per_page = 10;

        // Calcular el offset
        $offset = ($current_page - 1) * $orders_per_page;

        // Instanciar el modelo y obtener las órdenes paginadas
        $orders = new OC_model();

        $data["titulo"] = "Ordenes de compra";
        $data["orden"] = $orders->get_orders_paginated($offset, $orders_per_page);

        // Obtener el total de órdenes para calcular el número total de páginas
        $total_orders = $orders->get_total_orders();
        $data["total_pages"] = ceil($total_orders / $orders_per_page);

        // Pasar la página actual a la vista
        $data["current_page"] = $current_page;
        // Verificar si el usuario tiene permisos para acceder a esta función
        // Coloca aquí la lógica para verificar los permisos del usuario si es necesario

        // Obtener el número de orden a buscar del formulario
        $num_orden = $_POST['num_orden'];


        // Si el número de orden está vacío, redirigir a la página principal
        if (empty($num_orden)) {
            header('Location: home.php?c=sesion&a=index');
            exit;
        }

        // Llamar al modelo para realizar la búsqueda en la base de datos
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $OCmodel = new OC_model();
        $data['titulo'] = "Resultados de la búsqueda";
        $data['orden'] = $OCmodel->buscarPorNumeroOrden($num_orden);

        // Cargar la vista con los resultados de la búsqueda
        require_once "views/sesion/index.php";
        exit();
    }

}

?>