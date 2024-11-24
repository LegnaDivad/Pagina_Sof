<?php

require "funciones/conecta.php";
$con = conecta();

$correo = $_POST['correo'];


$sql = "SELECT COUNT(*) AS count FROM empleados WHERE correo = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


if ($row['count'] > 0) {
    echo '1'; 
} else {
    echo '0';   
}

$stmt->close();
$con->close();
?>
