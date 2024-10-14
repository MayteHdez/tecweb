<?php
include_once __DIR__ . '/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');

if (!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO
    $jsonOBJ = json_decode($producto);

    // Validaciones
    if (empty($jsonOBJ->nombre) || strlen($jsonOBJ->nombre) > 100) {
        echo json_encode(["message" => "El nombre es requerido y debe tener 100 caracteres o menos."]);
        exit;
    }

    if (empty($jsonOBJ->marca)) {
        echo json_encode(["message" => "La marca es requerida."]);
        exit;
    }

    if (empty($jsonOBJ->modelo) || strlen($jsonOBJ->modelo) > 25) {
        echo json_encode(["message" => "El modelo es requerido y debe tener 25 caracteres o menos."]);
        exit;
    }

    if (empty($jsonOBJ->precio) || $jsonOBJ->precio <= 99.99) {
        echo json_encode(["message" => "El precio es requerido y debe ser mayor a 99.99."]);
        exit;
    }

    if (isset($jsonOBJ->detalles) && strlen($jsonOBJ->detalles) > 250) {
        echo json_encode(["message" => "Los detalles deben tener 250 caracteres o menos."]);
        exit;
    }

    if (empty($jsonOBJ->unidades) || $jsonOBJ->unidades < 0) {
        echo json_encode(["message" => "Las unidades son requeridas y deben ser mayores o iguales a 0."]);
        exit;
    }

    // Validar si el producto ya existe
    $query = "SELECT * FROM productos WHERE nombre = ? AND eliminado = 0";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $jsonOBJ->nombre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["message" => "El producto ya existe."]);
        exit;
    }

    // Insertar el nuevo producto
    $query = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssdsis", $jsonOBJ->nombre, $jsonOBJ->marca, $jsonOBJ->modelo, $jsonOBJ->precio, $jsonOBJ->detalles, $jsonOBJ->unidades, $jsonOBJ->imagen);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Producto agregado con éxito."]);
    } else {
        echo json_encode(["message" => "Error al agregar el producto: " . $stmt->error]);
    }

    // Cerrar la conexión
    $stmt->close();
}
?>
