<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <title>Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h3>PRODUCTOS</h3>
    
    <br/>
    
    <?php
    
        // Crear la conexión
        @$link = new mysqli('localhost', 'root', '123', 'marketzone');
        
        // Comprobar la conexión
        if ($link->connect_errno) {
            die('Falló la conexión: ' . $link->connect_error . '<br/>');
        }

        // Consulta para obtener productos con unidades menores o iguales al tope
        if ($result = $link->query("SELECT * FROM productos WHERE eliminado = 0")) {
            if ($result->num_rows > 0) {
                echo '<table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Unidades</th>
                                <th scope="col">Detalles</th>
                                <th scope="col">Imagen</th>
                            </tr>
                        </thead>
                        <tbody>';
                
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <th scope="row">' . $row['id'] . '</th>
                            <td>' . $row['nombre'] . '</td>
                            <td>' . $row['marca'] . '</td>
                            <td>' . $row['modelo'] . '</td>
                            <td>' . $row['precio'] . '</td>
                            <td>' . $row['unidades'] . '</td>
                            <td>' . utf8_encode($row['detalles']) . '</td>
                            <td><img src="' . $row['imagen'] . '" alt="Imagen" style="width:100px;height:100px;"/></td>
                          </tr>';
                }
                
                echo '</tbody></table>';
            } else {
                echo '<div class="alert alert-warning">No se encontraron productos.</div>';
            }

            // Liberar resultado
            $result->free();
        }

        // Cerrar conexión
        $link->close();
   
    ?>
</body>
</html>
