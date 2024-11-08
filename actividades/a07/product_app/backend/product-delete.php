<?php
namespace MyApi;

require_once __DIR__ . '/myapi/Products.php';

$product = new Products();
$product->deleteProduct($_POST['id']);
echo json_encode( $product->getData());
?>