<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("Location: index.php");  
    exit();
}

$nombre = $_SESSION['nomUser'];  
$id = $_SESSION['idUser'];       
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de administración</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('fondos/fondoBienvenidoEmpleado.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8); 
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            margin-top: 40px;
        }

        .welcome-msg {
            font-size: 24px;
            color: #0d1821;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="welcome-msg">Bienvenid@ <?php echo htmlspecialchars($nombre); ?> al Sistema de administración.</p>
        <!-- Incluir el menú -->
        <?php include "menu.php"; ?>
    </div>
</body>
</html>