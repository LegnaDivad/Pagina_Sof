<?php
//verificarEmpleado.php
session_start();
require "../administrador/funciones/conecta.php";
$con = conecta();

//Cacho variables 
$email = $_REQUEST["correo"];
$password = $_REQUEST["pass"];

$sql = "SELECT * FROM clientes WHERE correo = '$email' AND pass = '$password' AND eliminado = 0";
$res = $con -> query($sql);

$num = $res -> num_rows;

if($num==1){
$row = $res->fetch_array();
$id = $row["id"];
$nombre = $row["nombre"]." ".$row["apellidos"];
$correo = $row["correo"];

$_SESSION["idUser"] = $id;
$_SESSION["nomUser"] = $nombre;
$_SESSION["correoUser"] = $correo;

}
echo "$num";
?>
