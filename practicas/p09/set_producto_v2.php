<?php
// Conexión a la base de datos
@$link = new mysqli('localhost', 'root', '123', 'marketzone');

// Verificar la conexión
if ($link->connect_errno) {
    die('Falló la conexión: ' . $link->connect_error);
}

// Recibir los datos del formulario mediante POST
$nombre   = $_POST['nombre'] ?? '';
$marca    = $_POST['marca'] ?? '';
$modelo   = $_POST['modelo'] ?? '';
$precio   = floatval($_POST['precio'] ?? 0);
$detalles = $_POST['detalles'] ?? '';
$unidades = intval($_POST['unidades'] ?? 0);

// Validar que todos los campos estén completos
if (empty($nombre) || empty($marca) || empty($modelo)) {
    die('Error: Todos los campos son obligatorios.');
}

// Verificar si se subió una imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
    $nombreImagen = $_FILES['imagen']['name'];
    $rutaImagen = __DIR__ . '/img/' . basename($nombreImagen);

    // Subir la imagen a la carpeta "img"
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
        die('Error al subir la imagen.');
    }
} else {
    $rutaImagen = 'img/default.png'; // Imagen por defecto si no se sube ninguna
}

// Validar que el nombre, modelo y la marca no existan ya en la BD
$sql = "SELECT * FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?";
$stmt = $link->prepare($sql);

// Verificar si la consulta fue preparada correctamente
if ($stmt === false) {
    die('Error en la preparación de la consulta SQL: ' . $link->error);
}

// Asignar los valores correspondientes
$stmt->bind_param('sss', $nombre, $marca, $modelo);

// Ejecutar la consulta
$stmt->execute();

// Obtener los resultados
$result = $stmt->get_result();

// Verificar si ya existe un producto con los mismos datos
if ($result->num_rows > 0) {
    die('Error: Ya existe un producto con el mismo nombre, modelo y marca.');
}

// Si no existe, insertar el nuevo producto en la BD
$sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt_insert = $link->prepare($sql_insert);

// Verificar si se preparó correctamente
if ($stmt_insert === false) {
    die('Error en la preparación de la consulta de inserción: ' . $link->error);
}

$eliminado = 0;
$stmt_insert->bind_param('sssdsis', $nombre, $marca, $modelo, $precio, $detalles, $unidades, $rutaImagen, $eliminado);

// Ejecutar la inserción
if ($stmt_insert->execute()) {
    echo 'Producto insertado correctamente.<br>';
    echo 'Nombre: ' . htmlspecialchars($nombre) . '<br>';
    echo 'Marca: ' . htmlspecialchars($marca) . '<br>';
    echo 'Modelo: ' . htmlspecialchars($modelo) . '<br>';
    echo 'Precio: ' . htmlspecialchars($precio) . '<br>';
    echo 'Detalles: ' . htmlspecialchars($detalles) . '<br>';
    echo 'Unidades: ' . htmlspecialchars($unidades) . '<br>';
    echo 'Imagen: <img src="' . htmlspecialchars($rutaImagen) . '" width="100"><br>';
} else {
    echo 'Error al insertar el producto: ' . $link->error;
}

// Cerrar las declaraciones y la conexión
$stmt->close();
$stmt_insert->close();
$link->close();
?>

