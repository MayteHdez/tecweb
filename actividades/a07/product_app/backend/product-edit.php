<?php
namespace MyApi;

require_once 'myapi/Products.php';

if (isset($_POST['id'], $_POST['nombre'], $_POST['descripcion'])) {
    $product = new Products();
    $response = $product->editProduct($_POST['id'], $_POST['nombre'], $_POST['descripcion']);
    echo json_encode($response);  // Asegúrate de que el servidor siempre retorne un JSON válido
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Faltan datos en la solicitud'
    ]);
}

