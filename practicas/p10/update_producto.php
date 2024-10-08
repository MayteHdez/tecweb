<?php
// Conexión a la base de datos
$link = mysqli_connect("localhost", "root", '123', 'marketzone');

// Verificar conexión
if ($link === false) {
    die("ERROR: No pudo conectarse con la base de datos. " . mysqli_connect_error());
}

// Recibir datos del formulario y validarlos
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$marca = isset($_POST['marca']) ? trim($_POST['marca']) : '';
$modelo = isset($_POST['modelo']) ? trim($_POST['modelo']) : '';
$precio = isset($_POST['precio']) ? (float)$_POST['precio'] : 0;
$detalles = isset($_POST['detalles']) ? trim($_POST['detalles']) : '';
$unidades = isset($_POST['unidades']) ? (int)$_POST['unidades'] : 0;

// Inicializar un arreglo de errores
$errores = [];

// Validaciones
if ($id <= 0) {
    $errores[] = "ID de producto inválido.";
}

if (empty($nombre) || strlen($nombre) > 100) {
    $errores[] = "El nombre es obligatorio y debe tener menos de 100 caracteres.";
}

if (empty($marca) || !in_array($marca, ['Marca1', 'Marca2', 'Marca3'])) {
    $errores[] = "La marca seleccionada no es válida.";
}

if (empty($modelo) || strlen($modelo) > 25) {
    $errores[] = "El modelo es obligatorio y debe tener menos de 25 caracteres.";
}

if ($precio <= 0) {
    $errores[] = "El precio debe ser un valor positivo.";
}

if (strlen($detalles) > 250) {
    $errores[] = "Los detalles no deben exceder los 250 caracteres.";
}

if ($unidades < 0) {
    $errores[] = "La cantidad de unidades no puede ser negativa.";
}

// Comprobar si hay errores
if (!empty($errores)) {
    // Mostrar los errores al usuario
    echo "<ul>";
    foreach ($errores as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
} else {
    // Si no hay errores, proceder a la actualización
    $sql = "UPDATE productos SET 
            nombre = '".mysqli_real_escape_string($link, $nombre)."', 
            marca = '".mysqli_real_escape_string($link, $marca)."', 
            modelo = '".mysqli_real_escape_string($link, $modelo)."', 
            precio = $precio, 
            detalles = '".mysqli_real_escape_string($link, $detalles)."', 
            unidades = $unidades 
            WHERE id = $id";

    if (mysqli_query($link, $sql)) {
        echo "Producto actualizado correctamente.";
    } else {
        echo "ERROR: No se pudo ejecutar la consulta: $sql. " . mysqli_error($link);
    }
}

// Cierra la conexión
mysqli_close($link);
?>
