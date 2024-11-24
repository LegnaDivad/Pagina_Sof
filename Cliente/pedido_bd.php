<?php
require "../Administrador/funciones/conecta.php";

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['nombreUser'])) {
    $con = conecta();
    $id_cliente = $_SESSION['idUser'];

    $sql_actualizar_pedido = "UPDATE pedidos SET status = 1 WHERE status = 0 AND id_clientes = $id_cliente";
    if ($con->query($sql_actualizar_pedido)) {
        echo "success";
    } else {
        http_response_code(500);
        echo "Error al enviar el pedido";
    }

    $con->close();
} else {
    http_response_code(401);
    echo "No se ha iniciado sesión";
}
?>
