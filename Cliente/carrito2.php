<?php
session_start();
require "menu_cliente.php";

require "../Administrador/funciones/conecta.php";
$con = conecta();

$id_cliente = $_SESSION['idUser'];

$sql_productos_carrito = "SELECT ped.id AS id_pedido, pp.id AS id_detalle, p.nombre AS nombre_producto, pp.cantidad, p.costo
                          FROM pedidos_productos pp
                          INNER JOIN productos p ON pp.id_producto = p.id
                          INNER JOIN pedidos ped ON pp.id_pedido = ped.id
                          WHERE ped.status = 0 AND ped.id_cliente = $id_cliente";
$res_productos_carrito = $con->query($sql_productos_carrito);

$carrito_productos = [];
$carrito_total = 0;

while ($row = $res_productos_carrito->fetch_assoc()) {
    $total = $row['cantidad'] * $row['costo'];
    $carrito_total += $total;

    $carrito_productos[] = [
        'id_detalle' => $row['id_detalle'],
        'nombre_producto' => $row['nombre_producto'],
        'cantidad' => $row['cantidad'],
        'costo_unitario' => $row['costo'],
        'total' => $total
    ];
}

$con->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Carrito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white; 
            color: #333;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        h1 {
            text-align: center;
            color: #c82a54;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #ffe6e6; 
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #ffccd5; 
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #ffebef; 
        }

        .subtotal {
            font-weight: bold;
        }

        #boton_enviar {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 20px 0;
            background-color: #c82a54; 
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        #boton_enviar:hover {
            background-color: #a92245; 
        }

        .mensaje {
            text-align: center;
            margin: 20px 0;
        }

        footer {
            margin-top: 20px;
            background-color: #c82a54;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            margin-top: 130px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Carrito 2/2</h1>
        <?php if (!empty($carrito_productos)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito_productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>
                            <td>$<?php echo number_format($producto['costo_unitario'], 2); ?></td>
                            <td>$<?php echo number_format($producto['total'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="total">Total:</td>
                        <td class="total">$<?php echo number_format($carrito_total, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="mensaje">No hay productos en el carrito.</p>
        <?php endif; ?>
        
        <button id="boton_enviar">Finalizar pedido</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#boton_enviar').click(function(){
                $.ajax({
                    url: 'pedido_bd.php',
                    type: 'POST',
                    success: function(response) {
                        if (response.trim() === "success") {
                            alert('Pedido recibido.');
                            setTimeout(function() {
                                window.location.href = 'bienvenido.php';
                            });
                        } else {
                            alert('Error: ' + response);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + status + ' - ' + error);
                    }
                });
            });
        });
    </script>

    <footer>
        <p> 2024 BRUNO'S. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
