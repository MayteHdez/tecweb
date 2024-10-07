<?php
/* MySQL Conexion */
$link = mysqli_connect("localhost", "root", '123', 'marketzone');
// Chequea conexión
if ($link === false) {
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Recibir datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0; // ID del producto
    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
    $marca = mysqli_real_escape_string($link, $_POST['marca']);
    $modelo = mysqli_real_escape_string($link, $_POST['modelo']);
    $precio = (float)$_POST['precio'];
    $detalles = mysqli_real_escape_string($link, $_POST['detalles']);
    $unidades = (int)$_POST['unidades'];

    // Ejecuta la actualización del registro
    $sql = "UPDATE productos SET nombre='$nombre', marca='$marca', modelo='$modelo', precio='$precio', detalles='$detalles', unidades='$unidades' WHERE id='$id'";

    if (mysqli_query($link, $sql)) {
        echo "Registro actualizado.";
    } else {
        echo "ERROR: No se ejecutó $sql. " . mysqli_error($link);
    }
}

// Cierra la conexión
mysqli_close($link);
?>
