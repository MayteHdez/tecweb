<?php
namespace MyApi;

require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = [];
    private $response = [];

    // Constructor de Products, pasando los parámetros a DataBase
    public function __construct($host = 'localhost', $user = 'root', $pass = '123', $dbname = 'marketzone') {
        // Llamando al constructor de la clase base (DataBase)
        parent::__construct($host, $user, $pass, $dbname);
    }


      // Devolver los datos en formato array
      public function getData() {
        return $this->response;
    }


    // Agregar producto
    public function addProduct($name, $precio, $unidades, $modelo, $marca, $detalles = 'Sin detalles', $imagen = 'imgdefault.png') {
        // Comprobación de si el producto ya existe
        $checkQuery = $this->conexion->prepare("SELECT * FROM productos WHERE nombre = ? AND eliminado = 0");
        $checkQuery->bind_param('s', $name);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();

        if ($checkResult->num_rows > 0) {
            // Si ya existe, mandamos un mensaje de error
            $this->response = array(
                'status'  => 'error',
                'message' => 'Ya existe un producto con ese nombre'
            );
        } else {
            // Si no existe, insertamos el nuevo producto
            $insertQuery = $this->conexion->prepare("INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen) 
                                                     VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param('sdissss', $name, $precio, $unidades, $modelo, $marca, $detalles, $imagen);
            $result = $insertQuery->execute();

            if ($result) {
                $this->response = array(
                    'status'  => 'success',
                    'message' => 'Producto agregado'
                );
            } else {
                $this->response = array(
                    'status'  => 'error',
                    'message' => "ERROR: No se ejecutó la inserción. " . $this->conexion->error
                );
            }
        }
    }

    // Verificar si el nombre del producto ya existe
    public function checkName($nombre) {
        // Validación del nombre
        if (empty($nombre)) {
            $this->response = ['exists' => false];
            return $this->getData(); // Respuesta inmediata si el nombre está vacío
        }

        // Consulta para verificar si el nombre ya existe
        $sql = "SELECT COUNT(*) as count FROM productos WHERE nombre = ? AND eliminado = 0";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Comprobamos si el producto ya existe
        $exists = $row['count'] > 0;

        // Respuesta en formato JSON
        $this->response = ['exists' => $exists];

        // Cerrar la consulta y devolver la respuesta
        $stmt->close();
        return $this->getData();
    }

    // Eliminar producto
    public function deleteProduct($id) {
        // Verificamos que el ID no sea nulo
        if (!isset($id) || empty($id)) {
            $this->response = [
                'status' => 'error',
                'message' => 'ID no proporcionado'
            ];
            return $this->getData();
        }

        // Consulta para actualizar el campo 'eliminado' del producto
        $sql = "UPDATE productos SET eliminado = 1 WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            $this->response = [
                'status' => 'error',
                'message' => 'Error en la preparación de la consulta: ' . $this->conexion->error
            ];
            return $this->getData();
        }

        // Vinculamos el parámetro (id) a la consulta preparada
        $stmt->bind_param("i", $id);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            $this->response = [
                'status' => 'success',
                'message' => 'Producto eliminado con éxito'
            ];
        } else {
            $this->response = [
                'status' => 'error',
                'message' => 'ERROR: No se ejecutó la eliminación. ' . $stmt->error
            ];
        }

        // Cerramos la declaración
        $stmt->close();
        
        return $this->getData(); // Retornamos la respuesta en formato JSON
    }

    // Editar producto
    public function editProduct($id, $name, $description) {
        // Validamos que los parámetros necesarios estén presentes
        if (empty($id) || empty($name) || empty($description)) {
            $this->response = [
                'status' => 'error',
                'message' => 'Faltan datos obligatorios'
            ];
            return $this->getData();
        }

        // Intentamos decodificar el JSON recibido en description
        $product_data = json_decode($description, true);

        if ($product_data === null) {
            // Si el JSON no es válido
            $this->response = [
                'status' => 'error',
                'message' => 'Formato de JSON no válido.'
            ];
            return $this->getData();
        }

        // Extraemos los valores del JSON
        $precio = mysqli_real_escape_string($this->conexion, $product_data['precio']);
        $unidades = mysqli_real_escape_string($this->conexion, $product_data['unidades']);
        $modelo = mysqli_real_escape_string($this->conexion, $product_data['modelo']);
        $marca = mysqli_real_escape_string($this->conexion, $product_data['marca']);
        $detalles = mysqli_real_escape_string($this->conexion, $product_data['detalles']);
        $imagen = mysqli_real_escape_string($this->conexion, $product_data['imagen']);

        // Sanitizamos el nombre y el id
        $name = mysqli_real_escape_string($this->conexion, $name);
        $id = mysqli_real_escape_string($this->conexion, $id);

        // Preparamos la consulta SQL para actualizar el producto
        $query = "UPDATE productos SET 
                    nombre = '$name', 
                    precio = '$precio', 
                    unidades = '$unidades', 
                    modelo = '$modelo', 
                    marca = '$marca', 
                    detalles = '$detalles', 
                    imagen = '$imagen' 
                  WHERE id = '$id'";

        // Ejecutamos la consulta
        if ($this->conexion->query($query)) {
            // Si la consulta fue exitosa
            $this->response = [
                'status' => 'success',
                'message' => 'Producto editado con éxito'
            ];
        } else {
            // Si ocurre un error en la ejecución de la consulta
            $this->response = [
                'status' => 'error',
                'message' => 'ERROR: No se ejecutó la consulta. ' . $this->conexion->error
            ];
        }

        return $this->getData(); // Retornamos la respuesta en formato JSON
    }

    public function listProducts() {
        $sql = "SELECT id, nombre, precio FROM productos WHERE eliminado = 0";
        $result = $this->conexion->query($sql);

        if ($result->num_rows > 0) {
            $this->response['status'] = 'success';
            $this->response['data'] = $result->fetch_all(MYSQLI_ASSOC); 
        } else {
            $this->response['status'] = 'error';
            $this->response['message'] = 'No se encontraron productos';
        }
    }

  
    
    
    

    // Buscar un producto por nombre
    public function searchProduct($search) {
        // Validamos que el parámetro de búsqueda esté presente
        if (empty($search)) {
            $this->response = [
                'status' => 'error',
                'message' => 'El parámetro de búsqueda está vacío.'
            ];
            return $this->getData();
        }

        // Preparamos la consulta SQL para realizar la búsqueda
        $search = mysqli_real_escape_string($this->conexion, $search);
        $sql = "SELECT * FROM productos 
                WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') 
                AND eliminado = 0";

        // Ejecutamos la consulta
        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!empty($rows)) {
                // Codificamos los resultados a UTF-8 y los agregamos a la respuesta
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->response[$num][$key] = utf8_encode($value);
                    }
                }
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'No se encontraron productos.'
                ];
            }
            $result->free();
        } else {
            // En caso de error con la consulta
            $this->response = [
                'status' => 'error',
                'message' => 'Error en la consulta: ' . $this->conexion->error
            ];
        }

        // Cerramos la conexión
        $this->conexion->close();

        return $this->getData(); // Devolvemos los resultados en formato JSON
    }

    // Obtener un solo producto por ID
    public function singleById($id) {
        // Sanitizamos el ID para evitar inyecciones SQL
        $id = mysqli_real_escape_string($this->conexion, $id);

        // Realizamos la consulta para obtener el producto por su ID
        $query = "SELECT * FROM productos WHERE id = $id";
        $result = $this->conexion->query($query);

        // Verificamos si la consulta fue exitosa
        if (!$result) {
            $this->response = [
                'status' => 'error',
                'message' => 'La consulta falló: ' . $this->conexion->error
            ];
            return $this->getData();
        }

        // Si no se encuentran resultados
        if ($result->num_rows === 0) {
            $this->response = [
                'status' => 'error',
                'message' => 'Producto no encontrado'
            ];
            return $this->getData();
        }

        // Recuperamos el primer producto encontrado
        $row = $result->fetch_assoc();

        // Mapear los datos a un array y agregarlo a la respuesta
        $this->response = [
            'id' => $row['id'],
            'nombre' => utf8_encode($row['nombre']),
            'precio' => $row['precio'],
            'unidades' => $row['unidades'],
            'modelo' => $row['modelo'],
            'marca' => $row['marca'],
            'detalles' => utf8_encode($row['detalles']),
            'imagen' => $row['imagen']
        ];

        // Liberar el resultado
        $result->free();

        // Devolvemos los datos del producto en formato JSON
        return $this->getData();
    }

    // Obtener un solo producto por nombre
    /*
    public function singleByName($nombre) {
        $query = $this->conexion->prepare("SELECT * FROM productos WHERE nombre = :nombre");
        $query->bindParam(':nombre', $nombre);
        $query->execute();
        $this->response = $query->fetch(\PDO::FETCH_ASSOC);
    }*/


}
