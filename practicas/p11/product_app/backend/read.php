<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = [];
    // SE VERIFICA HABER RECIBIDO LA BÚSQUEDA
if( isset($_POST['search']) ) {
    $search = $_POST['search'];

    // SE REALIZA LA QUERY DE BÚSQUEDA CON LIKE
    if ($result = $conexion->query("SELECT * FROM productos WHERE nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%'")) {
        
        // SE OBTIENEN LOS RESULTADOS
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $data[] = $row;  // AGREGAR CADA PRODUCTO AL ARREGLO DE RESPUESTA
        }
			$result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
        }
		$conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>