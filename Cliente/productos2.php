<?php
require_once "../Administrador/funciones/conecta.php";
$con = conecta();
$sqlProductos = "SELECT id, nombre, archivo, costo FROM productos";
$resProductos = $con->query($sqlProductos);

$productos = [];
while ($row = $resProductos->fetch_assoc()) {
    $productos[] = $row;
}

$numeroDeProductos = 6;
$productosAleatorios = [];
if (count($productos) > 0) {
    $indicesAleatorios = array_rand($productos, min($numeroDeProductos, count($productos)));
    if (!is_array($indicesAleatorios)) {
        $indicesAleatorios = [$indicesAleatorios];
    }
    foreach ($indicesAleatorios as $index) {
        $productosAleatorios[] = $productos[$index];
    }
}

$con->close();
?>
