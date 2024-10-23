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

        $query = "UPDATE productos SET nombre= '$name', detalles = '$description' WHERE 
        id = '$id'";
if (mysqli_query($conexion, $query)) {
    // Si la consulta fue exitosa
    $data['status'] = "success";
    $data['message'] = "Producto editado con éxito";
} else {
    // Si ocurre un error en la ejecución de la consulta
    $data['message'] = "ERROR: No se ejecutó la consulta. " . mysqli_error($conexion);
}

// Cerrar la conexión
$conexion->close();
} else {
// Si no se reciben los datos necesarios
$data['message'] = "ERROR: Faltan datos obligatorios.";
}

// Convertir el array a JSON y devolver la respuesta
echo json_encode($data, JSON_PRETTY_PRINT);

?>