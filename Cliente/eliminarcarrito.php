<?php
session_start();

require "../Administrador/funciones/conecta.php";
$con = conecta();

if (isset($_POST['id_detalle'])) {
    $id_detalle = $_POST['id_detalle'];

    $sql = "DELETE FROM pedidos_productos WHERE id = $id_detalle";
    $res = $con->query($sql);

    if ($con->affected_rows > 0) {
        $id_cliente = $_SESSION['idUser'];
        $sql_check_pedido = "SELECT pp.id
                             FROM pedidos_productos pp
                             INNER JOIN pedidos ped ON pp.id_pedido = ped.id
                             WHERE ped.status = 0 AND ped.id_clientes = $id_cliente";
        $res_check_pedido = $con->query($sql_check_pedido);

        if ($res_check_pedido->num_rows == 0) {
            $sql_delete_pedido = "DELETE FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
            $con->query($sql_delete_pedido);
        }

        header("Location: carrito1.php?msg=Producto eliminado exitosamente");
    } else {
        header("Location: carrito1.php?msg=Error al eliminar el producto");
    }
} else {
    header("Location: carrito1.php");
}

$con->close();
exit();
?>