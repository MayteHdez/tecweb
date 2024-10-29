<?php
// product-check-name.php

// Incluir el archivo de conexión a la base de datos
require 'database.php'; 

// Obtener el nombre del producto del parámetro GET
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';

// Preparar la consulta para verificar si el nombre existe
$sql = "SELECT COUNT(*) as count FROM productos WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Devolver respuesta en formato JSON
$response = array("exists" => $row['count'] > 0);
echo json_encode($response);

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
