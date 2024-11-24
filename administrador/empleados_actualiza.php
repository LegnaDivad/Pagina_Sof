<?php

require "funciones/conecta.php";

error_log("empleados_actualiza.php started");

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
$apellidos = $_POST['apellidos'] ?? '';
$correo = $_POST['correo'] ?? '';
$rol = $_POST['rol'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($id) || empty($nombre) || empty($apellidos) || empty($correo) || empty($rol)) {
    error_log("Missing required fields");
    echo "Faltan campos por llenar.";
    exit;
}

$sql_check = "SELECT id FROM empleados WHERE correo = ? AND id != ? AND eliminado = 0";
$stmt_check = $con->prepare($sql_check);
if (!$stmt_check) {
    error_log("Prepare failed: " . $con->error);
    echo "Error en la preparación de la consulta.";
    exit;
}
$stmt_check->bind_param("si", $correo, $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    error_log("Email already exists");
    echo "El correo ya existe.";
    exit;
}

$stmt_check->close();

$sql = "UPDATE empleados SET nombre = ?, apellidos = ?, correo = ?, rol = ?";
$params = array($nombre, $apellidos, $correo, $rol);
$types = "ssss";

if (!empty($password)) {
    $hashed_password = md5($password);
    $sql .= ", pass = ?";
    $params[] = $hashed_password;
    $types .= "s";
}

// Manejo de la foto
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $foto = $_FILES['foto'];
    $nombreFoto = $foto['name'];
    $nombreFotoHash = md5(uniqid() . $nombreFoto) . '.' . pathinfo($nombreFoto, PATHINFO_EXTENSION);
    $rutaDestino = 'fotos_empleados/' . $nombreFotoHash;

    if (!file_exists('fotos_empleados/')) {
        mkdir('fotos_empleados/', 0777, true);
    }

    if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
        $sql .= ", imagen = ?, imagen_hash = ?";
        $params[] = $nombreFoto;
        $params[] = $nombreFotoHash;
        $types .= "ss";
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
    error_log("Employee updated successfully");
    echo "1";  // Éxito
} else {
    error_log("Error updating employee: " . $stmt->error);
    echo "Error al actualizar el empleado.";
}

$stmt->close();
$con->close();

ob_end_flush();
?>