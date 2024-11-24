<?php

require "funciones/conecta.php";

error_log("promociones_actualiza.php started");

$con = conecta();

if (!$con) {
    error_log("Database connection failed: " . mysqli_connect_error());
    echo "Error de conexión a la base de datos.";
    exit;
}

error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

$id = $_POST['id'] ?? '';
$nombre = $_POST['nombre'] ?? '';
 



if (empty($id) || empty($nombre)) {
    error_log("Missing required fields");
    echo "Faltan campos por llenar.";
    exit;
}

$sql_check = "SELECT id FROM promociones WHERE nombre = ? AND id != ? AND eliminado = 0";
$stmt_check = $con->prepare($sql_check);
if (!$stmt_check) {
    error_log("Prepare failed: " . $con->error);
    echo "Error en la preparación de la consulta.";
    exit;
}
$stmt_check->bind_param("si", $nombre, $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

$stmt_check->close();

$sql = "UPDATE promociones SET nombre = ?";
$params = array($nombre);
$types = "s";


// Manejo de la foto
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $foto = $_FILES['foto'];
    $nombreFoto = $foto['name'];
    $nombreFotoHash = md5(uniqid() . $nombreFoto) . '.' . pathinfo($nombreFoto, PATHINFO_EXTENSION);
    $rutaDestino = 'fotosPromociones/' . $nombreFotoHash;

    if (!file_exists('fotosPromociones/')) {
        mkdir('fotosPromociones/', 0777, true);
    }

    if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
        $sql .= ", archivo = ?";
        $params[] = $nombreFotoHash;
        $types .= "s";
    } else {
        error_log("Failed to move uploaded file");
        echo "Error al subir la imagen.";
        exit;
    }
}

$sql .= " WHERE id = ?";
$params[] = $id;
$types .= "i";

error_log("SQL query: " . $sql);
error_log("Params: " . print_r($params, true));

$stmt = $con->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $con->error);
    echo "Error en la preparación de la consulta de actualización.";
    exit;
}

$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    error_log("promotion updated successfully");
    echo "1";  // Éxito
} else {
    error_log("Error updating promotion: " . $stmt->error);
    echo "Error al actualizar la promoción.";
}

$stmt->close();
$con->close();

ob_end_flush();
?>