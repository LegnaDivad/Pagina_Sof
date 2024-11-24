<?php
// Cachar archivo
$file_name = $_FILES['archivo']['name']; // Obtener el nombre del archivo subido
$file_tmp = $_FILES['archivo']['tmp_name']; // Obtener el nombre temporal del archivo subido

// Obtener extensión
$arreglo = explode('.', $file_name); // Dividir el nombre del archivo por el punto para separar la extensión
$len = count($arreglo); // Contar el número de elementos en el arreglo
$pos = $len - 1; // Obtener la posición del último elemento (la extensión)
$ext = $arreglo[$pos]; // Obtener la extensión del archivo

// Ruta para salvar
$dir = "archivos/"; // Directorio donde se guardará el archivo

// Obtener nuevoNombreUnico
$file_enc = md5_file($file_tmp); // Crear un hash MD5 del archivo temporal para obtener un nombre único
$fileName = "$file_enc.$ext"; // Crear el nuevo nombre del archivo con la extensión original

// Imprimir información del archivo
echo "file_name: $file_name <br>";
echo "file_tmp: $file_tmp <br>";
echo "ext: $ext <br>";
echo "dir: $dir <br>";

copy($file_tmp, $dir . $fileName); // Copiar el archivo temporal al directorio con el nuevo nombre
?>

