<?php
// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Conectar a la base de datos
    @$link = new mysqli('localhost', 'root', '123', 'marketzone');

    // Verificar la conexión
    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
    }

    // Obtener los datos enviados desde el formulario
    $nombre = $_POST['nombre'];
    $marca  = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $detalles = $_POST['detalles'];
    $unidades = $_POST['unidades'];

    // Procesar la imagen (subir la imagen)
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombreImagen = $_FILES['imagen']['name'];
        $rutaImagen = 'img/' . basename($nombreImagen); // Carpeta donde se guardará la imagen

        // Subir la imagen a la carpeta "img"
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            die('Error al subir la imagen.');
        }
    } else {
        $rutaImagen = 'img/default.png'; // Imagen por defecto si no se sube ninguna
    }

    // Validar que el nombre, marca y modelo no existan en la base de datos
    $sql = "SELECT * FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('sss', $nombre, $marca, $modelo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Si el producto ya existe, mostrar un mensaje de error
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error</title>
        </head>
        <body>
            <h1>Error al insertar el producto</h1>
            <p>El producto con nombre, marca y modelo ya existe en la base de datos.</p>
            <a href="formulario_productos.html">Regresar al formulario</a>
        </body>
        </html>';
    } else {
        // Si no existe, insertar el producto en la base de datos
        $sqlInsert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $link->prepare($sqlInsert);
        $stmtInsert->bind_param('sssdsis', $nombre, $marca, $modelo, $precio, $detalles, $unidades, $rutaImagen);

        if ($stmtInsert->execute()) {
            // Mostrar un resumen de los datos insertados en caso de éxito
            echo '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Producto Insertado</title>
            </head>
            <body>
                <h1>Producto insertado correctamente</h1>
                <p><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</p>
                <p><strong>Marca:</strong> ' . htmlspecialchars($marca) . '</p>
                <p><strong>Modelo:</strong> ' . htmlspecialchars($modelo) . '</p>
                <p><strong>Precio:</strong> $' . htmlspecialchars($precio) . '</p>
                <p><strong>Detalles:</strong> ' . htmlspecialchars($detalles) . '</p>
                <p><strong>Unidades:</strong> ' . htmlspecialchars($unidades) . '</p>
                <p><strong>Imagen:</strong> <img src="' . htmlspecialchars($rutaImagen) . '" alt="Imagen del producto" style="width:100px;"></p>
                <a href="formulario_productos.html">Registrar otro producto</a>
            </body>
            </html>';
        } else {
            // Mostrar un mensaje de error si la inserción falla
            echo '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Error</title>
            </head>
            <body>
                <h1>Error al insertar el producto</h1>
                <p>Ocurrió un error al intentar insertar el producto en la base de datos.</p>
                <a href="formulario_productos.html">Regresar al formulario</a>
            </body>
            </html>';
        }
    }

    // Cerrar la conexión
    $stmt->close();
    $stmtInsert->close();
    $link->close();
} else {
    // Si no es una solicitud POST, redirigir al formulario
    header('Location: formulario_productos.html');
}
?>
