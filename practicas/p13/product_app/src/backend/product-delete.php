<?php
    require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
    use MyApi\Delete\Delete;

    $productos = new Delete('marketzone');
    $productos->delete( $_POST['id'] );
    echo $productos->getData();
?>