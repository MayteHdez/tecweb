<?php
include('database.php');

$id =$_POST['id'];
$query = "SELECT * FROM productos WHERE id= $id";
$result = mysqli_query($conexion, $query);
if (!$result){
    die('Querry falló');
}

$json =array();
while($row = mysqli_fetch_array($result)){
    $json[] = array(
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'precio' => $row['precio'],
        'unidades' => $row['unidades'],
        'modelo' => $row['modelo'],
        'marca' => $row['marca'],
        'detalles' => $row['detalles'],
        'imagen' => $row['imagen'],

    );
}

$jsonstring = json_encode($json[0]);
echo $jsonstring;

?>