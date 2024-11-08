<?php
namespace MyApi;

require_once 'myapi/Products.php';

$product = new Products();
$product->editProduct($_POST['id'], $_POST['nombre'], $_POST['descripcion']);
echo json_encode( $product->getData());
?>