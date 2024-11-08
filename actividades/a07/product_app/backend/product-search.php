<?php
namespace MyApi;

require_once 'myapi/Products.php';

$product = new Products();
$product->searchProduct($_POST['nombre']);
echo json_encode($product->getData());
?>