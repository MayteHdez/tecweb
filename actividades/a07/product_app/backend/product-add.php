<?php

namespace MyApi;

require_once 'myapi/Products.php';

$product = new Products();
$product->addProduct($_POST['nombre'], $_POST['descripcion']);
echo json_encode($product->getData());

?>


