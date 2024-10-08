<?php
// MySQL Conexion
$link = mysqli_connect("localhost", "root", '123', 'marketzone');

// Verificar conexión
if ($link === false) {
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];

// Manejar la imagen subida
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $rutaImagen = 'img/' . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
} else {
    // Usar imagen por defecto si no se subió ninguna
    $rutaImagen = 'img/imagenpre.jpg';
}

// Actualizar el producto en la base de datos
$sql = "UPDATE productos SET nombre='$nombre', marca='$marca', modelo='$modelo', precio='$precio', detalles='$detalles', unidades='$unidades', imagen='$rutaImagen' WHERE id=$id";

if (mysqli_query($link, $sql)) {
    echo "Producto actualizado correctamente.";
} else {
    echo "ERROR: No pudo ejecutar $sql. " . mysqli_error($link);
}

// Cierra la conexión
mysqli_close($link);
?>
