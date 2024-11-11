<?php
    require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
    use MyApi\Update\Update;

    $productos = new Update('marketzone');
    $productos->edit( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>