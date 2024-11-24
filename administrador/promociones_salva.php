<?php
session_start();
require "funciones/conecta.php";
$con = conecta();


$nombre = $_POST['nombre'] ?? '';
$foto = $_FILES['foto'] ?? null;
$nombreFoto = $foto['name'] ?? '';
$archivo_nombre = '';
$carpeta = __DIR__ . '/fotosPromociones/';

if ($foto && $foto['error'] == 0) {
   
    $nombreFotoHash = md5(uniqid($nombreFoto, true)) . '.' . pathinfo($nombreFoto, PATHINFO_EXTENSION);
    $rutaDestino = $carpeta . $nombreFotoHash;

    
    if (!file_exists($carpeta)) {
        if (!mkdir($carpeta, 0777, true)) {
            echo "No se pudo crear la carpeta de destino en " . $carpeta;
            exit;
        }
    } else {
        echo "Carpeta existente y con permisos adecuados.";
    }

    if (is_writable($carpeta)){
        echo "La carpeta es escribible";
    } else {
        echo "Error: La carpeta no tiene permisos de escritura.";
        exit;
    }

    if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
        echo "Imagen subida correctamente a " . $rutaDestino;
        $archivo_nombre = $nombreFotoHash; 
    } else {
        echo "Error al mover la imagen a " . $rutaDestino ;
        exit;
    }
} else {
    echo "Error en el archivo subido. Código de error: " . $foto['error'];
    exit;
}


$sql = "INSERT INTO promociones (nombre, archivo) VALUES (?, ?)";
$stmt = $con->prepare($sql);

if (!$stmt) {
    echo "Error en la preparación de la consulta.";
    exit;
}

$stmt->bind_param("ss", $nombre, $archivo_nombre);

if ($stmt->execute()) {
    $_SESSION['promocion'] = [
        'nombre' => $nombre,
    ];

    header("Location: promociones_lista.php");
    exit;
} else {
    echo "Error al guardar la promoción: " . $stmt->error;
}

$stmt->close();
$con->close();
?>