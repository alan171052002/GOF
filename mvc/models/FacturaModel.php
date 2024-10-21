<?php
class FacturaModel
{
    private $db;
    private $facturas;

    public function __construct()
    {
        $this->db = Conectar::conexion();
        $this->facturas = array();
    }

    // Métodos para facturas
    public function insertar($num_factura, $fecha, $parcialidades, $pdf)
    {
        $num_factura = $this->db->real_escape_string($num_factura);
        $fecha = $this->db->real_escape_string($fecha);
        $parcialidades = $this->db->real_escape_string($parcialidades);

        $resultado = $this->db->query("INSERT INTO facturas (num_factura, fecha, parcialidades,pdf) VALUES ('$num_factura', '$fecha', '$parcialidades','$pdf')");
    }

    public function modificar($num_factura, $fecha, $parcialidades, $pdf)
    {
        $num_factura = $this->db->real_escape_string($num_factura);
        $fecha = $this->db->real_escape_string($fecha);
        $parcialidades = $this->db->real_escape_string($parcialidades);

        $resultado = $this->db->query("UPDATE facturas SET num_factura = '$num_factura', fecha='$fecha', parcialidades='$parcialidades', pdf='$pdf' WHERE num_factura = '$num_factura'");
    }

    public function eliminar($num_factura)
    {
        $num_factura = $this->db->real_escape_string($num_factura);

        $resultado = $this->db->query("DELETE FROM facturas WHERE num_factura = '$num_factura'");
    }

    public function getFactura($num_factura)
    {
        $num_factura = $this->db->real_escape_string($num_factura);
        $sql = "SELECT * FROM facturas WHERE num_factura='$num_factura' LIMIT 1";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        return $row;
    }
    public function getFacturas()
    {
        $sql = "SELECT * FROM facturas";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->facturas[] = $row;
        }
        return $this->facturas;
    }

    public function asociarOrdenFactura($num_orden, $num_factura)
    {
        $num_orden = $this->db->real_escape_string($num_orden);
        $num_factura = $this->db->real_escape_string($num_factura);

        $resultado = $this->db->query("INSERT INTO ordenes_facturas (num_orden, num_factura) VALUES ('$num_orden', '$num_factura')");
    }

    public function existePDF($pdf_destination)
    {
        $pdf_destination = $this->db->real_escape_string($pdf_destination);

        $sql = "SELECT COUNT(*) AS count FROM facturas WHERE pdf = '$pdf_destination'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'] > 0; // Devuelve true si existe al menos un registro con la misma ruta del PDF
        } else {
            // Manejar el error o retorno según tu lógica de la aplicación
            return false;
        }
    }

    public function obtenerOrdenesDeFactura($num_factura)
    {
        $num_factura = $this->db->real_escape_string($num_factura);

        $sql = "SELECT * FROM ordenes_facturas WHERE num_factura = '$num_factura'";
        $resultado = $this->db->query($sql);

        $ordenes = array();
        while ($row = $resultado->fetch_assoc()) {
            $ordenes[] = $row;
        }

        return $ordenes;
    }

    public function obtenerFacturasDeOrden($num_orden)
    {
        $num_orden = $this->db->real_escape_string($num_orden);

        $sql = "SELECT * FROM ordenes_facturas WHERE num_orden = '$num_orden'";
        $resultado = $this->db->query($sql);

        $facturas = array();
        while ($row = $resultado->fetch_assoc()) {
            $facturas[] = $row;
        }

        return $facturas;
    }
    public function getFacturasAsociadas($num_orden)
    {
        $sql = "SELECT f.num_factura AS numero_factura, f.fecha AS fecha_factura, f.pdf AS pdf_factura,
        o.num_orden AS numero_orden
 FROM facturas f
 INNER JOIN ordenes_facturas ofac ON f.num_factura = ofac.num_factura
 INNER JOIN orden o ON ofac.num_orden = o.num_orden
 WHERE o.num_orden = '$num_orden'";

        // Ejecutar la consulta
        $result = $this->db->query($sql);

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Array para almacenar los resultados
            $facturas = array();

            // Iterar sobre los resultados y almacenarlos en el array
            while ($row = $result->fetch_assoc()) {
                $facturas[] = $row;
            }

            // Devolver los resultados
            return $facturas;
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según tu lógica de la aplicación
            return array();
        }
    }
    public function getOrdenesAsociadas($num_factura)
    {
        $sql = "SELECT f.num_factura AS numero_factura, f.fecha AS fecha_factura, f.pdf AS pdf_factura,
                       o.num_orden AS numero_orden, o.pdf AS pdf_orden
                FROM facturas f
                INNER JOIN ordenes_facturas ofac ON f.num_factura = ofac.num_factura
                INNER JOIN orden o ON ofac.num_orden = o.num_orden
                WHERE f.num_factura = '$num_factura'";


        // Ejecutar la consulta
        $result = $this->db->query($sql);

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Array para almacenar los resultados
            $facturas = array();

            // Iterar sobre los resultados y almacenarlos en el array
            while ($row = $result->fetch_assoc()) {
                $facturas[] = $row;
            }

            // Devolver los resultados
            return $facturas;
        } else {
            // Si no hay resultados, devolver un array vacío o lanzar una excepción según tu lógica de la aplicación
            return array();
        }
    }
    public function buscarPorNumeroOrden($num_factura)
    {
        $num_factura = $this->db->real_escape_string($num_factura);
        $sql = "SELECT * FROM facturas WHERE num_factura = '$num_factura'";

        $resultado = $this->db->query($sql);
        $ordenes = array();
        while ($row = $resultado->fetch_assoc()) {
            $ordenes[] = $row;
        }

        return $ordenes;
    }
    public function getFacturasNoAsociadas($num_orden)
    {
        // Query para obtener las facturas que no están asociadas a una orden específica
        $query = "SELECT * FROM facturas 
                  WHERE num_factura NOT IN (
                      SELECT num_factura 
                      FROM ordenes_facturas 
                      WHERE num_orden = ?
                  )";

        // Preparar la sentencia para evitar inyección SQL
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $num_orden);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $facturasNoAsociadas[] = $row;
            }
            return $facturasNoAsociadas;
        } else {
            return array(); // Retorna un array vacío si no se encuentran facturas no asociadas
        }
    }

}


?>