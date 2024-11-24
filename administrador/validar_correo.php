<?php
require "funciones/conecta.php"; // Asegúrate de que la ruta es correcta

$con = conecta();

// Verifica si se ha enviado el correo a través de AJAX
if (isset($_POST['correo'])) {
    $correo = $_POST['correo'];

    // Consulta para verificar si el correo ya existe y no ha sido eliminado
    $sql = "SELECT * FROM empleados WHERE correo = ? AND eliminado = 0";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Devuelve 1 si el correo ya existe, de lo contrario devuelve 0
    if ($result->num_rows > 0) {
        echo 1; // Correo ya existe
    } else {
        echo 0; // Correo no existe
    }
}
?>