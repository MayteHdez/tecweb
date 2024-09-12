<?php
$parqueVehicular = [
    'UBN6338' => [
        'Auto' => ['marca' => 'HONDA', 'modelo' => 2020, 'tipo' => 'camioneta'],
        'Propietario' => ['nombre' => 'Alfonzo Esparza', 'ciudad' => 'Puebla, Pue.', 'direccion' => 'C.U., Jardines de San Manuel']
    ],
    'UBN6339' => [
        'Auto' => ['marca' => 'MAZDA', 'modelo' => 2019, 'tipo' => 'sedan'],
        'Propietario' => ['nombre' => 'Ma. del Consuelo Molina', 'ciudad' => 'Puebla, Pue.', 'direccion' => '97 oriente']
    ],
    'XYZ1234' => [
        'Auto' => ['marca' => 'TOYOTA', 'modelo' => 2021, 'tipo' => 'sedan'],
        'Propietario' => ['nombre' => 'José Martínez', 'ciudad' => 'Ciudad de México', 'direccion' => 'Av. Reforma 123']
    ],
    'LMN5678' => [
        'Auto' => ['marca' => 'FORD', 'modelo' => 2018, 'tipo' => 'camioneta'],
        'Propietario' => ['nombre' => 'Laura Gómez', 'ciudad' => 'Guadalajara, Jalisco', 'direccion' => 'Calle 5 de Febrero 456']
    ],
    'ABC9012' => [
        'Auto' => ['marca' => 'NISSAN', 'modelo' => 2020, 'tipo' => 'hatchback'],
        'Propietario' => ['nombre' => 'Carlos López', 'ciudad' => 'Monterrey, NL', 'direccion' => 'Calle Juárez 789']
    ],
    'DEF3456' => [
        'Auto' => ['marca' => 'CHEVROLET', 'modelo' => 2017, 'tipo' => 'sedan'],
        'Propietario' => ['nombre' => 'Ana Ruiz', 'ciudad' => 'Tijuana, BC', 'direccion' => 'Av. Agua Caliente 321']
    ],
    'GHI7890' => [
        'Auto' => ['marca' => 'HYUNDAI', 'modelo' => 2022, 'tipo' => 'hatchback'],
        'Propietario' => ['nombre' => 'Roberto Sánchez', 'ciudad' => 'Puebla, Pue.', 'direccion' => 'Calle 10 Oriente 654']
    ],
    'JKL1235' => [
        'Auto' => ['marca' => 'KIA', 'modelo' => 2019, 'tipo' => 'camioneta'],
        'Propietario' => ['nombre' => 'Sofia Hernández', 'ciudad' => 'Querétaro', 'direccion' => 'Calle Hidalgo 789']
    ],
    'MNO6789' => [
        'Auto' => ['marca' => 'VOLKSWAGEN', 'modelo' => 2021, 'tipo' => 'sedan'],
        'Propietario' => ['nombre' => 'Luis Fernández', 'ciudad' => 'San Luis Potosí', 'direccion' => 'Av. Carranza 456']
    ],
    'PQR2345' => [
        'Auto' => ['marca' => 'BMW', 'modelo' => 2018, 'tipo' => 'camioneta'],
        'Propietario' => ['nombre' => 'Marta Gómez', 'ciudad' => 'Cancún, QR', 'direccion' => 'Calle 12 Norte 123']
    ],
    'STU6780' => [
        'Auto' => ['marca' => 'AUDI', 'modelo' => 2020, 'tipo' => 'hatchback'],
        'Propietario' => ['nombre' => 'Fernando Díaz', 'ciudad' => 'Aguascalientes', 'direccion' => 'Calle 45 Poniente 567']
    ],
    'VWX3457' => [
        'Auto' => ['marca' => 'SUBARU', 'modelo' => 2019, 'tipo' => 'sedan'],
        'Propietario' => ['nombre' => 'Patricia Martínez', 'ciudad' => 'Toluca', 'direccion' => 'Calle 3 de Febrero 890']
    ],
    'YZA9013' => [
        'Auto' => ['marca' => 'JEEP', 'modelo' => 2021, 'tipo' => 'camioneta'],
        'Propietario' => ['nombre' => 'Alejandro Vargas', 'ciudad' => 'Chihuahua', 'direccion' => 'Calle 9 Norte 456']
    ],
    'BCD2346' => [
        'Auto' => ['marca' => 'MITSUBISHI', 'modelo' => 2022, 'tipo' => 'hatchback'],
        'Propietario' => ['nombre' => 'Elena Ramírez', 'ciudad' => 'Hermosillo', 'direccion' => 'Calle 14 Sur 123']
    ],
    'EFG6781' => [
        'Auto' => ['marca' => 'FIAT', 'modelo' => 2018, 'tipo' => 'sedan'],
        'Propietario' => ['nombre' => 'Jorge López', 'ciudad' => 'Chilpancingo', 'direccion' => 'Calle 8 Oriente 456']
    ],
    'HIJ9014' => [
        'Auto' => ['marca' => 'PEUGEOT', 'modelo' => 2020, 'tipo' => 'camioneta'],
        'Propietario' => ['nombre' => 'Carmen Sánchez', 'ciudad' => 'Morelia', 'direccion' => 'Calle 2 Norte 789']
    ],
    'JKL2346' => [
        'Auto' => ['marca' => 'RENAULT', 'modelo' => 2021, 'tipo' => 'hatchback'],
        'Propietario' => ['nombre' => 'Raúl Delgado', 'ciudad' => 'Irapuato', 'direccion' => 'Calle 11 Poniente 654']
    ],
    'LMN6782' => [
        'Auto' => ['marca' => 'NISSAN', 'modelo' => 2019, 'tipo' => 'sedan'],
        'Propietario' => ['nombre' => 'Lucía Torres', 'ciudad' => 'Puebla', 'direccion' => 'Av. Juárez 987']
    ]
];

header('Content-Type: application/xhtml+xml; charset=UTF-8');
echo "<?xml version='1.0' encoding='UTF-8' ?>";
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>";
echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='es'>";
echo "<head><title>Resultado Ejercicio 6</title></head>";
echo "<body>";

if (isset($_POST['matricula']) && !empty($_POST['matricula'])) {
    $matricula = $_POST['matricula']; 

    if (array_key_exists($matricula, $parqueVehicular)) {
        $auto = $parqueVehicular[$matricula];
        echo "<h2>Información del vehículo con matrícula $matricula</h2>";
        echo "<p>Marca: {$auto['Auto']['marca']}</p>";
        echo "<p>Modelo: {$auto['Auto']['modelo']}</p>";
        echo "<p>Tipo: {$auto['Auto']['tipo']}</p>";
        echo "<p>Propietario: {$auto['Propietario']['nombre']}</p>";
        echo "<p>Ciudad: {$auto['Propietario']['ciudad']}</p>";
        echo "<p>Dirección: {$auto['Propietario']['direccion']}</p>";
    } else {
        echo "<h2>No se encontró ningún vehículo con la matrícula $matricula</h2>";
    }
} elseif (isset($_POST['todos_autos'])) {
    echo "<h2>Lista de todos los autos registrados</h2>";
    foreach ($parqueVehicular as $matricula => $datos) {
        echo "<h3>Matrícula: $matricula</h3>";
        echo "<p>Marca: {$datos['Auto']['marca']}</p>";
        echo "<p>Modelo: {$datos['Auto']['modelo']}</p>";
        echo "<p>Tipo: {$datos['Auto']['tipo']}</p>";
        echo "<p>Propietario: {$datos['Propietario']['nombre']}</p>";
        echo "<p>Ciudad: {$datos['Propietario']['ciudad']}</p>";
        echo "<p>Dirección: {$datos['Propietario']['direccion']}</p>";
        echo "<hr />";
    }
}

echo "</body></html>";
?>
