<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $message = $_POST['message'];

    $to = 'azul.casillas0276@alumnos.udg.mx'; 
    $subject = 'Nuevo mensaje de ' . $nombre; 
    $body = "Nombre: $nombre\nMensaje:\n$message"; 
    $headers = "From: $to";

    $smtpUsername = 'azul.casillas0276@alumnos.udg.mx'; 
    $smtpPassword = '020103simental'; 

    if (mail($to, $subject, $body, $headers, '-f' . $smtpUsername)) {
        echo "<script>alert('El mensaje ha sido enviado exitosamente.'); window.location.href = 'index.php';</script>";
        exit; 
    } else {
        echo "<script>alert('NO se pudo enviar el mensaje.'); window.location.href = 'promos.php';</script>";
        exit;
    }
}
?>
