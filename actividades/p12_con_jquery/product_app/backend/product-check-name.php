<?php
// Incluye tu archivo de conexión a la base de datos
include 'database.php'; // Asegúrate de que esta ruta sea correcta

// Asegúrate de que la conexión a la base de datos se establezca correctamente
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener el nombre del producto desde la solicitud GET
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';

if ($nombre === '') {
    echo json_encode(['exists' => false]);
    exit();
}

// Consulta para verificar si el nombre ya existe
$sql = "SELECT COUNT(*) as count FROM productos WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$exists = $row['count'] > 0;

// Respuesta en formato JSON
header('Content-Type: application/json'); // Asegúrate de enviar el tipo de contenido correcto
echo json_encode(['exists' => $exists]);

$stmt->close();
$conn->close();
?>

