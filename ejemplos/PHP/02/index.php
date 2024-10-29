<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 2</title>
</head>
<body>
    <?php
    require_once __DIR__. '/Menu.php';

    $l1 = new Menu();
    $l1->cargar_opcion('https://wwww.facebook.com','Facebook');
    $l1->cargar_opcion('https://wwww.instagram.com','Instagram');
    $l1->cargar_opcion('https://wwww.x.com','X');
    $l1->mostrar();


    ?>    
</body>
</html>