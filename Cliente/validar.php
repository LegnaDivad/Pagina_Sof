<?php
session_start();
require_once("../Administrador/funciones/conecta.php");

function validarUsuario($correo, $pass) {
    $con = conecta();

    if ($con->connect_error) {
        die("Conexión fallida: " . $con->connect_error);
    }

    $sql = "SELECT * FROM clientes WHERE correo = ? AND pass = ?";
    $stmt = $con->prepare($sql);

    $stmt->bind_param("ss", $correo,  $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "success";
        $row = $result->fetch_array();
        $id = $row["id_clientes"];
        $nombre = $row["nombre"];
        $correo = $row["correo"];

        $_SESSION['idUser'] = $id;
        $_SESSION['nombreUser'] = $nombre;
        $_SESSION['correoUser'] = $correo;
    } else {
        echo "Nombre de usuario o contraseña incorrectos";
    }

    $stmt->close();
    $con->close();
}

$correo = $_POST['correo'];
$pass = $_POST['pass'];

validarUsuario($correo, $pass);
?>
