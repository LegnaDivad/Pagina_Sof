<!DOCTYPE html>
<html lang="es">
<head>
    <style>
        .nav-table {
            background-color: #0D1821;
            border-collapse: collapse;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            width: 100%;
            max-width: 800px;
        }

        .nav-table td {
            padding: 15px 25px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .nav-table a {
            color: #F0F4EF;
            text-decoration: none;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            display: block;
            transition: color 0.3s ease;
        }

        .nav-table td:hover {
            background-color: #344966;
        }

        .nav-table td:hover a {
            color: #E6AACE;
        }

        .nav-table td:last-child {
            background-color: #344966;
        }

        .nav-table td:last-child:hover {
            background-color: #E6AACE;
        }

        .nav-table td:last-child a {
            color: #BFCC94;
        }

        .nav-table td:last-child:hover a {
            color: #0D1821;
        }
    </style>
</head>
<body>
    <table class="nav-table">
        <tr>
            <td><a href="bienvenidoEmpleado.php">INICIO</a></td>
            <td><a href="empleados_lista.php">EMPLEADOS</a></td>
            <td><a href="productos_lista.php">PRODUCTOS</a></td>
            <td><a href="promociones_lista.php">PROMOCIONES</a></td>
            <td><a href="pedidos_lista.php">PEDIDOS</a></td>
            <td><a href="salir.php">SALIR</a></td>
        </tr>
    </table>
</body>
</html>