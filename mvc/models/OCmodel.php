<?php

class OC_model
{
    private $db;
    private $orden;

    public function __construct()
    {
        $this->db = Conectar::conexion();
        $this->orden = array();
    }

    public function get_orders()
    {
        $sql = "SELECT * FROM orden";
        $resultado = $this->db->query($sql);
        while ($row = $resultado->fetch_assoc()) {
            $this->orden[] = $row;
        }
        return $this->orden;
    }


    public function insertar($num_orden, $departamento,$observaciones,$estado ,$pdf)
    {
        $num_orden = $this->db->real_escape_string($num_orden);
        $departamento = $this->db->real_escape_string($departamento);
        $observaciones = $this->db->real_escape_string($observaciones);
        $pdf = $this->db->real_escape_string($pdf);


        $resultado = $this->db->query("INSERT INTO orden (num_orden, departamento, observaciones, estado,  pdf) VALUES ('$num_orden', '$departamento','$observaciones','$estado', '$pdf')");

    }

    public function modificar($num_orden, $departamento,$observaciones,$estado, $pdf)
    {
        $num_orden = $this->db->real_escape_string($num_orden);
        $departamento = $this->db->real_escape_string($departamento);
        $observaciones = $this->db->real_escape_string($observaciones);
        $estado = $this->db->real_escape_string($estado);
        $pdf = $this->db->real_escape_string($pdf);

        $resultado = $this->db->query("UPDATE orden SET num_orden='$num_orden', departamento='$departamento', observaciones='$observaciones', estado='$estado' , pdf='$pdf' WHERE num_orden = '$num_orden'");
    }

    public function eliminar($num_orden)
    {
        $num_orden = $this->db->real_escape_string($num_orden);

        $resultado = $this->db->query("DELETE FROM orden WHERE num_orden = '$num_orden'");
    }

    public function get_order($num_orden)
    {
        $num_orden = $this->db->real_escape_string($num_orden);
        $sql = "SELECT * FROM orden WHERE num_orden='$num_orden' LIMIT 1";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();

        return $row;
    }
    public function getOrdenesNoAsociadas($num_factura)
    {
        // Query para obtener las órdenes que no están asociadas a una factura específica
        $query = "SELECT * FROM orden 
                  WHERE num_orden NOT IN (
                      SELECT num_orden 
                      FROM ordenes_facturas 
                      WHERE num_factura = ?
                  )";

        // Preparar la sentencia para evitar inyección SQL
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $num_factura);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $OrdenesNoAsociadas[] = $row;
            }
            return $OrdenesNoAsociadas;
        } else {
            return array(); // Retorna un array vacío si no se encuentran órdenes no asociadas
        }
    }
    public function ordenar($tipo_usuario)
    {
        $tipo_usuario = $this->db->real_escape_string($tipo_usuario);
        $sql = "SELECT u.nombre AS Nombre, o.num_orden AS Numero_de_Orden, o.departamento AS Departamento
        FROM orden o
        JOIN usuarios u ON u.tipo_user = '$tipo_usuario'
        WHERE o.departamento = u.tipo_user";

        $resultado = $this->db->query($sql);

        $ordenes = array();
        while ($row = $resultado->fetch_assoc()) {
            $ordenes[] = $row;
        }

        return $ordenes;
    }
    public function existePDF($pdf_destination)
    {
        $pdf_destination = $this->db->real_escape_string($pdf_destination);

        $sql = "SELECT COUNT(*) AS count FROM orden WHERE pdf = '$pdf_destination'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'] > 0; // Devuelve true si existe al menos un registro con la misma ruta del PDF
        } else {
            // Manejar el error o retorno según tu lógica de la aplicación
            return false;
        }
    }
    public function buscarPorNumeroOrden($num_orden)
    {
        $num_orden = $this->db->real_escape_string($num_orden);
        $sql = "SELECT * FROM orden WHERE num_orden = '$num_orden'";

        $resultado = $this->db->query($sql);
        $ordenes = array();
        while ($row = $resultado->fetch_assoc()) {
            $ordenes[] = $row;
        }

        return $ordenes;
    }

    public function get_orders_paginated($offset, $limit) {
        $sql = "SELECT * FROM orden LIMIT $offset, $limit";
        $resultado = $this->db->query($sql);
        $ordenes = array();
        while ($row = $resultado->fetch_assoc()) {
            $ordenes[] = $row;
        }
        return $ordenes;
    }

    public function get_total_orders() {
        $sql = "SELECT COUNT(*) AS total FROM orden";
        $resultado = $this->db->query($sql);
        $row = $resultado->fetch_assoc();
        return $row['total'];
    }



}
?>