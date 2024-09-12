<?php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $edad = isset($_POST['edad']) ? $_POST['edad'] : null;
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : null;

    // Cabecera XHTML y respuesta
    echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
    <title>Resultado</title>
</head>
<body>
    <?php
    // Verificar si cumple con las condiciones
    if ($sexo === 'femenino' && $edad >= 18 && $edad <= 35) {
        echo '<h1>Bienvenida, usted está en el rango de edad permitido.</h1>';
    } else {
        echo '<h1>Error: No cumple con los requisitos.</h1>';
    }
    ?>
</body>
</html>
<?php
}
?>
