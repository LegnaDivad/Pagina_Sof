<?php
session_start();
require "funciones/conecta.php";
$con = conecta();

// Cachar variables
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$correo = $_POST['correo'] ?? '';
$pass = $_POST['pass'] ?? '';
$rol = $_POST['rol'] ?? '';

// Validar y encriptar la contraseña
$passEnc = md5($pass);

// Variables para la imagen
$foto = $_FILES['foto'] ?? null;
$nombreFoto = $foto['name'] ?? '';
$archivo_file = '';
$carpeta = 'fotos_empleados/';

if ($foto && $foto['error'] == 0) {
    // Crear un nombre de archivo único usando hash
    $nombreFotoHash = md5(uniqid($nombreFoto, true)) . '.' . pathinfo($nombreFoto, PATHINFO_EXTENSION);
    $rutaDestino = $carpeta . $nombreFotoHash;

    // Crear carpeta si no existe
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    // Mover archivo y asignar variables para DB
    if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
        $archivo_nombre = $nombreFoto; // Nombre original de la imagen
        $archivo_file = $nombreFotoHash; // Nombre único/hash de la imagen
    } else {
        echo "Error al subir la imagen.";
        exit;
    }
}

// Insertar en la base de datos usando consulta preparada
$sql = "INSERT INTO empleados (nombre, apellidos, correo, pass, rol, imagen, imagen_hash) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);

if (!$stmt) {
    echo "Error en la preparación de la consulta.";
    exit;
}

// Asociar variables a la consulta preparada
$stmt->bind_param("ssssiss", $nombre, $apellidos, $correo, $passEnc, $rol, $archivo_nombre, $archivo_file);

// Ejecutar y verificar
if ($stmt->execute()) {
    // Guardar los datos en la sesión
    $_SESSION['empleado'] = [
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'correo' => $correo,
        'rol' => $rol
    ];

    // Redireccionar a la lista de empleados
    header("Location: empleados_lista.php");
    exit;
} else {
    echo "Error al guardar el empleado: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
