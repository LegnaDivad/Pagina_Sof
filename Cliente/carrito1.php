<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <style>
        body {
            font-family: "Helvetica", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #000;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 20px;
        }

        .contenedor {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #c82a54;
            margin-bottom: 30px;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla th, .tabla td {
            text-align: left;
            padding: 10px;
        }

        .tabla th {
            background-color: #000;
            color: #fff;
        }

        .tabla tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabla tr:hover {
            background-color: #f1f1f1;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }

        button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c82a54;
        }

        footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 50px;
        }

        .mensaje {
            text-align: center;
            margin: 20px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <?php require "menu_cliente.php"; ?>
    </header>
    <div class="contenedor">
        <h1>Carrito</h1>
        <?php if (!empty($carrito_productos)): ?>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito_productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>
                            <td>$<?php echo number_format($producto['costo_unitario'], 2); ?></td>
                            <td>$<?php echo number_format($producto['total'], 2); ?></td>
                            <td>
                                <form method="post" action="eliminarcarrito.php">
                                    <input type="hidden" name="id_detalle" value="<?php echo $producto['id_detalle']; ?>">
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="total">Total:</td>
                        <td colspan="2" class="total">$<?php echo number_format($total_carrito, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="mensaje">Tu carrito está vacío.</p>
        <?php endif; ?>
        <form action="carrito2.php" method="post" style="text-align: center; margin-top: 20px;">
            <input type="hidden" name="dato_ficticio" value="valor_ficticio">
            <button type="submit">Continuar</button>
        </form>
    </div>
    <footer>
    <p> Derechos Reservados 2024 Sofia Castellanos Lobo</p>    </footer>
</body>
</html>
