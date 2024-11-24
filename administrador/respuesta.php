<?php
//Comprueba si lo recibido es mayor a 60
$numero = $_REQUEST['numero'];
$ban= 0;
if($numero > 60){
    $ban = 1;
}
echo $ban;
?>