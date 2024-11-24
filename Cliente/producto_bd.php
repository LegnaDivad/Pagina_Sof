<?php
session_start();
require "menu_cliente.php";
require_once "../Administrador/funciones/conecta.php";

$con = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $id_producto = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $id_cliente = $_SESSION['idUser'];

    // Obtener id_pedido
    $sql = "SELECT * FROM pedidos WHERE status = 0 AND id_clientes = $id_cliente";
    $res = $con->query($sql);
    $num = $res->num_rows;
    if ($num == 0) {
        $fecha = date('Y-m-d H:i:s');  // Formato de fecha y hora
        $sql = "INSERT INTO pedidos (fecha, id_clientes) VALUES ('$fecha', $id_cliente)";
        if ($con->query($sql) === TRUE) {
            $id_pedido = $con->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        $row = $res->fetch_assoc();
        $id_pedido = $row['id'];
    }

    $sql = "SELECT costo FROM productos WHERE id = $id_producto";
    $res = $con->query($sql);
    $row = $res->fetch_assoc();
    $precio = $row['costo'];

    $sql = "SELECT * FROM pedidos_productos WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
    $res = $con->query($sql);
    $num = $res->num_rows;
    if ($num == 0) {
        $sql = "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad, precio) VALUES ($id_pedido, $id_producto, $cantidad, $precio)";
    } else {
        $row = $res->fetch_assoc();
        $idPP = $row['id'];
        $sql = "UPDATE pedidos_productos SET cantidad = cantidad + $cantidad WHERE id = $idPP";
    }
    if ($con->query($sql) === TRUE) {
        header("Location: carrito1.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>
