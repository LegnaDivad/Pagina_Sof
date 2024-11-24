<?php

session_start();  
if (!isset($_SESSION['idUser'])) {
    header("Location: index.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'funciones/conecta.php';

// Verificar si el ID ha sido enviado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Conectar a la base de datos
    $conexion = conecta();
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }

    // Consulta preparada para prevenir inyección SQL
    $query = "SELECT nombre, codigo, descripcion, costo, stock, archivo_n  FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $producto_id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (!$resultado) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    } else {
        $producto = mysqli_fetch_assoc($resultado);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "ID de producto no proporcionado o no válido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
    <style>
        .btn-regresar {
            background-color: #0D1821;
            color: #F0F4EF;
            text-decoration: none;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            padding: 15px 25px;
            text-align: center;
            border: none;
            border-radius: 8px;
            display: inline-block;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-regresar:hover {
            background-color: #344966;
            color: #E6AACE;
        }

        .btn-regresar:active {
            background-color: #E6AACE;
            color: #0D1821;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            color: #333;
        }

        .profile-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid #007bff;
            object-fit: cover;
        }

        .field {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .field label {
            font-weight: bold;
            color: #555;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <div class="header">
            <h2>Detalle del Producto</h2>
        </div>
        <div class="profile-image">

            <img src="fotos_productos/<?php echo $producto['archivo_n']; ?>">




        </div>
        <div class="field">
            <label>Nombre:</label>
            <span><?php echo htmlspecialchars($producto['nombre']); ?></span>
        </div>
        <div class="field">
            <label>Código:</label>
            <span><?php echo htmlspecialchars($producto['codigo']); ?></span>
        </div>
        <div class="field">
            <label>Descripción:</label>
            <span><?php echo htmlspecialchars($producto['descripcion']); ?></span>
        </div>
        <div class="field">
            <label>Costo:</label>
            <span><?php echo htmlspecialchars($producto['costo']); ?></span>
        </div>
        <div class="field">
            <label>Stock:</label>
            <span><?php echo htmlspecialchars($producto['stock']); ?></span>
        </div>
        
    </div>
    <a href="productos_lista.php" class="btn-regresar">Regresar</a>
</body>

</html>