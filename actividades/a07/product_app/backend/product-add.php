<?php

namespace MyApi;

require_once 'myapi/Products.php';

$product = new Products();

// Valida que todos los campos necesarios estén presentes antes de agregar el producto
if (isset($_POST['nombre'], $_POST['precio'], $_POST['unidades'], $_POST['modelo'], $_POST['marca'])) {
    // Llama a la función para agregar el producto
    $product->addProduct($_POST['nombre'], $_POST['precio'], $_POST['unidades'], $_POST['modelo'], $_POST['marca'], $_POST['detalles'], $_POST['imagen']);
} else {
    $product->setResponse('error', 'Faltan parámetros necesarios para agregar el producto');
}

// Devuelve la respuesta en formato JSON
echo json_encode($product->getData());

?>



