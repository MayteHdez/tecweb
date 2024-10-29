<?php
    include_once __DIR__.'/database.php';

    if (isset($_POST['name']) && isset($_POST['precio']) && isset($_POST['unidades']) && 
        isset($_POST['modelo']) && isset($_POST['marca'])) {

        $name = $_POST['name'];
        $precio = $_POST['precio'];
        $unidades = $_POST['unidades'];
        $modelo = $_POST['modelo'];
        $marca = $_POST['marca'];

        // Asignar valores por defecto si están vacíos
        $detalles = isset($_POST['detalles']) && !empty($_POST['detalles']) ? $_POST['detalles'] : 'Sin detalles';
        $imagen = isset($_POST['imagen']) && !empty($_POST['imagen']) ? $_POST['imagen'] : 'imgdefault.png';

        // Comprobación de si el producto ya existe
        $checkQuery = "SELECT * FROM productos WHERE nombre = '$name' AND eliminado = 0";
        $checkResult = mysqli_query($conexion, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Si ya existe, mandamos un mensaje de error
            $data = array(
                'status'  => 'error',
                'message' => 'Ya existe un producto con ese nombre'
            );
        } else {
            // Si no existe, insertamos el nuevo producto
            $query = "INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen) 
                      VALUES ('$name', '$precio', '$unidades', '$modelo', '$marca', '$detalles', '$imagen')";
            $result = mysqli_query($conexion, $query);

            if ($result) {
                $data = array(
                    'status'  => 'success',
                    'message' => 'Producto agregado'
                );
            } else {
                $data = array(
                    'status'  => 'error',
                    'message' => "ERROR: No se ejecutó la inserción. " . mysqli_error($conexion)
                );
            }
        }
    } else {
        // Si faltan los campos obligatorios
        $data = array(
            'status'  => 'error',
            'message' => 'Faltan datos obligatorios del producto'
        );
    }

    // Devolver respuesta en formato JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>

