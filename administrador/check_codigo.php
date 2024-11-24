<?php

require "funciones/conecta.php";
$con = conecta();

$codigo = $_POST['codigo'];

// Verificar que el código no esté vacío
if (empty($codigo)) {
    echo "Código no proporcionado.";
    exit;
}

// Consulta para verificar si el código ya existe
$sqlCheck = "SELECT COUNT(*) AS count FROM productos WHERE codigo = ?";
$stmtCheck = $con->prepare($sqlCheck);

if (!$stmtCheck) {
    echo "Error en la preparación de la consulta.";
    exit;
}

$stmtCheck->bind_param("s", $codigo);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck) {
    $rowCheck = $resultCheck->fetch_assoc();

    if ($rowCheck['count'] > 0) {
        echo "1"; // Producto ya existe
    } else {
        echo "0"; // Producto no existe
    }
} else {
    echo "Error al ejecutar la consulta.";
}

$stmtCheck->close();
$con->close();
?>
