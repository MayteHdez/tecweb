<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require_once __DIR__.'/Operacion.php';

    $suma = new Suma;
    $suma->setValor1(10); //Metodo heredado, pero definido en la clase 'Operacion'
    $suma->setValor2(10); //Metodo heredado, pero definido en la clase 'Operacion'
    $suma->operar();//Metodo definido en la clase 'Suma'

    echo 'El resultado es: '.$suma->getResultado().'<br>';

    $resta = new Resta;
    $resta->setValor1(10); //Metodo heredado, pero definido en la clase 'Operacion'
    $resta->setValor2(5); //Metodo heredado, pero definido en la clase 'Operacion'
    $resta->operar();//Metodo definido en la clase 'Resta'

    echo 'El resultado es: '.$resta->getResultado().'<br>';

    ?>
</body>
</html>