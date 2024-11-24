<?php
// funciones/conecta.php
define("HOST", 'localhost'); // computadora que me quiero conectar | podria ser la ip de otra compu también pero regularmente es localhost
define("BD",'Proyecto_sofi'); // base de datos 
define("USER_BD",'root'); // usuarios con que acceso a la base de datos
define("PASS_BD",''); // 4 constantes en total

function conecta(){
    $con = new mysqli(HOST, USER_BD, PASS_BD, BD); // funciona a partir de php7
    return $con;
}
?> 