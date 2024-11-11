<?php
    require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
    use MyApi\Read\Read;

    $productos = new Read('marketzone');
    $productos->search( $_GET['search'] );
    echo $productos->getData();
?>