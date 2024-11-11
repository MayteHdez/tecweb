<?php
    require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
    use MyApi\Create\Create;

    $productos = new Create('marketzone');
    $productos->add( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>