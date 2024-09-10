<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 7</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
    include_once 'src/funciones.php';

    if (isset($_GET['numero'])) {
        $numero = $_GET['numero'];
        // Llamar a la función para comprobar si el número es múltiplo de 5 y 7
        mult5y7($numero);
    }else {
        echo 'No se ha pasado ningún número en la URL.';
}
?>

    <h2>Ejercicio 2</h2>
    <p>Programa para la generación repetitiva de 3 números aleatorios</p>
    <?php
    generarSecuenciaValida();
    ?>
   <<!--
    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practicas/p04/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    #<php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>-->>
</body>
</html>