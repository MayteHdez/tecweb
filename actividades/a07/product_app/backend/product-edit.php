<?php
namespace MyApi;

require_once 'myapi/Products.php';

// Verificamos si los datos fueron enviados correctamente
if (isset($_POST['id'], $_POST['nombre'], $_POST['descripcion'])) {
    $product = new Products();
    $response = $product->editProduct($_POST['id'], $_POST['nombre'], $_POST['descripcion']);
    echo json_encode($response); // Retornamos la respuesta en formato JSON
} else {
    // Si no se recibieron todos los parámetros
    echo json_encode([
        'status' => 'error',
        'message' => 'Faltan datos en la solicitud'
    ]);
}
?>
