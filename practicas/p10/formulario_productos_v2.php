<?php
// MySQL Conexion
$link = mysqli_connect("localhost", "root", '123', 'marketzone');
// Chequea conexión
if ($link === false) {
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Obtener ID del producto a editar
$idProducto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Inicializar variable para almacenar el producto seleccionado
$productoSeleccionado = null;

// Consultar la base de datos para obtener el producto seleccionado
if ($idProducto > 0) {
    $sql = "SELECT * FROM productos WHERE id = $idProducto";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $productoSeleccionado = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontró el producto.";
    }
}

// Cierra la conexión
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        ol, ul {
            list-style-type: none;
        }
        .error {
            color: red;
        }
    </style>
    <title>Formulario de Productos</title>
</head>
<body>
    <h1>Registro de Productos</h1>

    <!-- Mensajes de error -->
    <div id="error-messages" class="error"></div>

    <form id="miFormulario" method="post" action="update_producto.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Actualiza los datos del producto:</legend>
            <input type="hidden" name="id" value="<?= isset($productoSeleccionado['id']) ? htmlspecialchars($productoSeleccionado['id']) : '' ?>">
            <ul>
                <li>
                    <label>Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= isset($productoSeleccionado['nombre']) ? htmlspecialchars($productoSeleccionado['nombre']) : '' ?>" required maxlength="100">
                </li>
                <li>
                    <label>Marca:</label>
                    <select name="marca" id="marca" required>
                        <option value="">Seleccione una marca</option>
                        <option value="Marca1" <?= (isset($productoSeleccionado['marca']) && $productoSeleccionado['marca'] == 'Marca1') ? 'selected' : '' ?>>Marca1</option>
                        <option value="Marca2" <?= (isset($productoSeleccionado['marca']) && $productoSeleccionado['marca'] == 'Marca2') ? 'selected' : '' ?>>Marca2</option>
                        <option value="Marca3" <?= (isset($productoSeleccionado['marca']) && $productoSeleccionado['marca'] == 'Marca3') ? 'selected' : '' ?>>Marca3</option>
                    </select>
                </li>
                <li>
                    <label>Modelo:</label>
                    <input type="text" id="modelo" name="modelo" value="<?= isset($productoSeleccionado['modelo']) ? htmlspecialchars($productoSeleccionado['modelo']) : '' ?>" required maxlength="25" pattern="[A-Za-z0-9]+">
                </li>
                <li>
                    <label>Precio:</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="99.99" value="<?= isset($productoSeleccionado['precio']) ? htmlspecialchars($productoSeleccionado['precio']) : '' ?>" required>
                </li>
                <li>
                    <label>Detalles:</label>
                    <textarea name="detalles" id="detalles" maxlength="250"><?= isset($productoSeleccionado['detalles']) ? htmlspecialchars($productoSeleccionado['detalles']) : '' ?></textarea>
                </li>
                <li>
                    <label>Unidades Disponibles:</label>
                    <input type="number" id="unidades" name="unidades" min="0" value="<?= isset($productoSeleccionado['unidades']) ? htmlspecialchars($productoSeleccionado['unidades']) : '' ?>" required>
                </li>
                <li>
                    <label>Imagen:</label>
                    <input type="file" name="imagen" accept="image/*">
                </li>
            </ul>
        </fieldset>
        <p>
            <input type="submit" value="Actualizar Producto">
        </p>
    </form>

    <script>
        document.getElementById('miFormulario').addEventListener('submit', function(event) {
            var errores = [];
            var nombre = document.getElementById('nombre').value.trim();
            var marca = document.getElementById('marca').value;
            var modelo = document.getElementById('modelo').value.trim();
            var precio = document.getElementById('precio').value;
            var detalles = document.getElementById('detalles').value.trim();
            var unidades = document.getElementById('unidades').value;

            // Validación de cada campo
            if (nombre === '' || nombre.length > 100) {
                errores.push('El nombre es obligatorio y debe tener 100 caracteres o menos.');
            }

            if (marca === '') {
                errores.push('Debe seleccionar una marca.');
            }

            if (modelo === '' || modelo.length > 25 || !/^[A-Za-z0-9]+$/.test(modelo)) {
                errores.push('El modelo es obligatorio, debe ser alfanumérico y tener 25 caracteres o menos.');
            }

            if (precio < 99.99 || isNaN(precio)) {
                errores.push('El precio debe ser mayor a 99.99.');
            }

            if (detalles.length > 250) {
                errores.push('Los detalles no deben exceder los 250 caracteres.');
            }

            if (unidades < 0 || isNaN(unidades)) {
                errores.push('Las unidades deben ser un número no negativo.');
            }

            // Mostrar errores si existen
            if (errores.length > 0) {
                event.preventDefault();  // Detener el envío del formulario
                document.getElementById('error-messages').innerHTML = '<ul><li>' + errores.join('</li><li>') + '</li></ul>';
            }
        });
    </script>
</body>
</html>
