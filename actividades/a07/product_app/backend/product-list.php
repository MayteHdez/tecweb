<?php
use MyApi\Products as Products;

require_once __DIR__ . '/myapi/Products.php';

// Establecer el encabezado para que la respuesta sea JSON
header('Content-Type: application/json; charset=utf-8');

// Instanciar la clase y listar productos
$product = new Products();
$product->listProducts();

// Obtener los datos
$data = $product->getData();

// Asegurarte de que json_encode() no falle
$json = json_encode($data);
if ($json === false) {
    // Retornar error si no se puede convertir a JSON
    echo json_last_error_msg(); 
} else {
    // Enviar la respuesta JSON
    echo $json;
}
?>

