
<?php

require "funciones/conecta.php";

$con = conecta();
$id = $_REQUEST['id'];
$sql = "UPDATE empleados SET eliminado = 1 WHERE id = $id"; // Elimina el empleado
$res = $con->query($sql); // Ejecuta la consulta


echo $con->affected_rows;
?>
