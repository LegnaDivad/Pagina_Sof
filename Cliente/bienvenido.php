<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("Location: index.php");  
    exit();
}

$nombre = $_SESSION['nomUser'];  
$id = $_SESSION['idUser'];    
require "menu_cliente.php";
require "../Administrador/funciones/conecta.php";
$con = conecta();

function obtenerPromociones($con) {
    $sql = "SELECT nombre, archivo FROM promociones";
    $resultados = $con->query($sql);
    $promociones = [];
    while ($row = $resultados->fetch_assoc()) {
        $promociones[] = $row;
    }
    return $promociones;
}

function seleccionarPromocionAleatoria($promociones) {
    if (count($promociones) > 0) {
        return $promociones[array_rand($promociones)];
    } else {
        return null;
    }
}

function obtenerProductosAleatorios($con) {
    $sql = "SELECT id, nombre, archivo, costo FROM productos ORDER BY RAND() LIMIT 6";
    $resultados = $con->query($sql);
    $productos = [];
    while ($row = $resultados->fetch_assoc()) {
        $productos[] = $row;
    }
    return $productos;
}

$promociones = obtenerPromociones($con);
$promocion_aleatoria = seleccionarPromocionAleatoria($promociones);

$productosAleatorios = obtenerProductosAleatorios($con);

$con->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Promociones y Productos</title>
    <style>
        nav {
            background-color: #000;
            color: #FFF;
            padding: 15px 0;
            text-align: center;
            font-family: "Helvetica", sans-serif;
        }

        body {
            font-family: "Helvetica", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFF;
            color: #000;
        }

        #banner {
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
        }

        #banner img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #banner p {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            color: #000;
        }

        #productos {
            max-width: 800px;
            margin: 20px auto;
            text-align: center;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 10px;
        }

        .producto {
            background-color: #FFF;
            border: 1px solid #CFB53B;
            padding: 15px;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .producto:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .producto img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-bottom: 1px solid #CFB53B;
            margin-bottom: 10px;
        }

        .producto p {
            margin: 5px 0;
        }

        .producto form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        button {
            background-color: #000;
            color: #FFF;
            border: 1px solid #CFB53B;
            border-radius: 3px;
            padding: 10px 20px;
            font-family: "Helvetica", sans-serif;
            cursor: pointer;
        }

        button:hover {
            background-color: #CFB53B;
            color: #000;
        }

        footer {
            margin-top: 20px;
            background-color: #000;
            color: #FFF;
            text-align: center;
            padding: 15px 0;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }
        #productos {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
    background-color: #fff;
    color: #000;
}

.producto {
    background-color: #fff;
    border: 1px solid #000;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    font-family: "Helvetica", sans-serif;
}

.producto img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin-bottom: 20px;
    border: 1px solid #000;
}

.producto:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.producto p {
    font-size: 16px;
    color: #333;
    margin: 10px 0;
}

.producto button {
    background-color: #000;
    color: #fff;
    border: 1px solid #fff;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Helvetica", sans-serif;
    font-size: 14px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.producto button:hover {
    background-color: #fff;
    color: #000;
    border: 1px solid #000;
}

footer {
    background-color: #000;
    color: #fff;
    text-align: center;
    padding: 15px 0;
    font-family: "Helvetica", sans-serif;
}
#productos {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh; /* Ajusta la altura al 80% de la pantalla */
    flex-wrap: wrap;
    background-color: #fff;
    color: #000;
}

.empty {
    text-align: center;
    font-size: 18px;
    color: #c82a54;
    font-family: "Helvetica", sans-serif;
}

    </style>
</head>
<body>
<div id="banner">
        <?php if ($promocion_aleatoria): ?>
            <img src="../administrador/fotos_promociones/<?php echo htmlspecialchars($promocion_aleatoria['archivo']); ?>" alt="Promoción">
            <p><?php echo htmlspecialchars($promocion_aleatoria['nombre']); ?></p>
        <?php else: ?>
            <p>No hay promociones disponibles.</p>
        <?php endif; ?>
    </div>
    <div id="productos">
        <?php if (!empty($productosAleatorios)): ?>
            <?php foreach ($productosAleatorios as $producto): ?>
                <div class="producto">
                    <img src="../administrador/fotos_productos/<?php echo htmlspecialchars($producto['archivo']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <p><?php echo htmlspecialchars($producto['nombre']); ?></p>
                    <p>Costo: $<?php echo number_format($producto['costo'], 2); ?></p>
                    <form method="post" action="producto_bd.php">
                        <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                        <label for="cantidad_<?php echo $producto['id']; ?>">Cantidad:</label>
                        <input type="number" id="cantidad_<?php echo $producto['id']; ?>" name="cantidad" min="1" value="1">
                        <button type="submit" style="color:#c82a54;">Agregar al carrito</button>
                    </form>
                    <button><a style="color:#c82a54;"href="productodetalle.php?id=<?php echo $producto['id']; ?>">Detalles</a></button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty">No hay productos disponibles.</p>
        <?php endif; ?>
    </div>
    <footer>
        <p> Derechos Reservados 2024 Sofia Castellanos Lobo</p>
    </footer>
</body>
</html>
