<?php
    include_once __DIR__.'/database.php';

    if(isset($_POST['name'])){
        $name =$_POST['name'];
        $description =$_POST['description'];
        $query = "INSERT into productos (nombre, detalles) VALUES('$name','$description')";
        $result = mysqli_query($conexion, $query);
        if(!$result){
            die('La query ha fallado');
        }
        echo 'Producto agregado satisfactoriamente';
    }

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    /*$producto = file_get_contents('php://input');
    error_log("Contenido recibido: " . $producto);


    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);

if ($jsonOBJ !== null && isset($jsonOBJ->name)) { // Verifica que los datos sean válidos

        $nombre = $jsonOBJ->name;
        $descripcion = $jsonOBJ->description ?? ''; // Obtiene la descripción

        // Aquí decodificamos la descripción como un objeto JSON
        $descripcionObj = json_decode($descripcion);

        $precio = $descripcionObj->precio ?? 0; // Valor por defecto
        $unidades = $descripcionObj->unidades ?? 1; // Valor por defecto
        $modelo = $descripcionObj->modelo ?? 'XX-000'; // Valor por defecto
        $marca = $descripcionObj->marca ?? 'NA'; // Valor por defecto
        $detalles = $descripcionObj->detalles ?? 'NA'; // Valor por defecto
        $imagen = $descripcionObj->imagen ?? 'img/default.png'; // Imagen por defecto

        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $sql = "SELECT * FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
	    $result = $conexion->query($sql);
        
        if ($result->num_rows == 0) {
            $conexion->set_charset("utf8");
            $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                    VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0)";
            if($conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto agregado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
            }
        }

        $result->free();
    } else {
        $data['message'] = "ERROR: JSON no valido.";
    }
}

        // Cierra la conexion
        $conexion->close();
    

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/
?>