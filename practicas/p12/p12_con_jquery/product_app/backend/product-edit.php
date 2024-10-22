<?php
    include('database.php');

    $id = $_POST['id'];
    $name = $_POST['name'];
    $descrIption = $_POST['description'];

    $query = "UPDATE productos SET name= '$name', detalles = '$description' WHERE 
    id = '$id'";

    $result = mysqli_query($conexion, $query);
    if(!$result){
        die('query fallido');
    }

    echo "Edición exitosa"

?>