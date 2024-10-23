<?php
    include_once __DIR__.'/database.php';

    if(isset($_POST['name'])){
        $name =$_POST['name'];
        $description =$_POST['description'];

        
        $checkQuery = "SELECT * FROM productos WHERE nombre = '$name' AND eliminado = 0";
        $checkResult = mysqli_query($conexion, $checkQuery);
    
        // Verificamos si ya existe un producto con ese nombre
        if(mysqli_num_rows($checkResult) > 0){
            // Si ya existe, mandamos un mensaje de error
            $data = array(
                'status'  => 'error',
                'message' => 'Ya existe un producto con ese nombre'
            );
        } else {

        //AGREGADOOO
        $product_data = json_decode($description, true);

        if ($product_data !== null) {
            // Extraer los valores del array
            $precio = $product_data['precio'];
            $unidades = $product_data['unidades'];
            $modelo = $product_data['modelo'];
            $marca = $product_data['marca'];
            $detalles = $product_data['detalles'];
            $imagen = $product_data['imagen'];

            $query = "INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen) 
              VALUES ('$name', '$precio', '$unidades', '$modelo', '$marca', '$detalles', '$imagen')";



            //$query = "INSERT into productos (nombre, detalles) VALUES('$name','$description')";
            $result = mysqli_query($conexion, $query);
            if($result){
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
    }}
    echo json_encode($data, JSON_PRETTY_PRINT);
    ?>
    