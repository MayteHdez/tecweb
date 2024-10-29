<?php
    include('database.php');

    $data = array(
        'status'  => 'error',
        'message' => 'La consulta falló'
    );

    if( isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) ) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        //$query = "UPDATE productos SET nombre= '$name', detalles = '$description' WHERE 
        //id = '$id'";

        // Intentamos decodificar el JSON recibido en description
        $product_data = json_decode($description, true);

        if ($product_data !== null) {
            // Extraemos los valores del JSON
            $precio = mysqli_real_escape_string($conexion, $product_data['precio']);
            $unidades = mysqli_real_escape_string($conexion, $product_data['unidades']);
            $modelo = mysqli_real_escape_string($conexion, $product_data['modelo']);
            $marca = mysqli_real_escape_string($conexion, $product_data['marca']);
            $detalles = mysqli_real_escape_string($conexion, $product_data['detalles']);
            $imagen = mysqli_real_escape_string($conexion, $product_data['imagen']);

            // Sanitizamos el nombre y el id
            $name = mysqli_real_escape_string($conexion, $name);
            $id = mysqli_real_escape_string($conexion, $id);

            $query = "UPDATE productos SET 
                        nombre = '$name', 
                        precio = '$precio', 
                        unidades = '$unidades', 
                        modelo = '$modelo', 
                        marca = '$marca', 
                        detalles = '$detalles', 
                        imagen = '$imagen' 
                     WHERE id = '$id'";


            // Ejecutamos la consulta
            if (mysqli_query($conexion, $query)) {
                // Si la consulta fue exitosa
                $data['status'] = "success";
                $data['message'] = "Producto editado con éxito";
            } else {
                // Si ocurre un error en la ejecución de la consulta
                $data['message'] = "ERROR: No se ejecutó la consulta. " . mysqli_error($conexion);
            }
        } else {
            // Si el JSON no es válido
            $data['message'] = "ERROR: Formato de JSON no válido.";
        }
    } else {
        // Si no se reciben los datos necesarios
        $data['message'] = "ERROR: Faltan datos obligatorios.";
    }

    // Cerrar la conexión
    $conexion->close();

    // Convertir el array a JSON y devolver la respuesta
    echo json_encode($data, JSON_PRETTY_PRINT);
?>