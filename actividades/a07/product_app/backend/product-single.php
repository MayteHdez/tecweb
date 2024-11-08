<?php
namespace MyApi;

require_once 'myapi/Products.php';

$product = new Products();
$product->singleById($_POST['id']); // O usar singleByName si se busca por nombre
echo json_encode($product->getData());
?>