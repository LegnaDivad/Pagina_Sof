<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Estilo Chanel Mejorado</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background-color: #FFFFFF;
            color: #000000;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            border-bottom: 1px solid #EAEAEA;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: white;
            padding-left: 10px;
        }
        .logo img {
            width: 80px;
            height: 80px;
            margin-right: 10px;
            border-radius: 50%; 
            padding: 5px 10px;
        }
        ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        li {
            margin: 0 20px;
        }
        li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.3s ease, border-bottom 0.3s ease;
            padding-bottom: 5px;
            border-bottom: 2px solid transparent;
        }
        li a:hover {
            color: #757575;
            border-bottom: 2px solid #757575;
        }
        .cta-button {
            padding: 10px 50px 10px;
            background-color: #000000;
            color: #FFFFFF;
            text-transform: uppercase;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
  
        }
        .cta-button:hover {
            background-color: #757575;
        }
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                text-align: center;
            }
            ul {
                flex-direction: column;
            }
            li {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo"> <img src="../administrador/images/th.jpg" alt="Icono de Bienvenido"></div>
        <ul>
            <li><a href="bienvenido.php">Inicio</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="form_correo.php">Contacto</a></li>
            <li><a href="carrito1.php">Carrito</a></li>
        </ul>
        <button class="cta-button" onclick="window.location.href='salirC.php';">Salir</button>
    </nav>
</body>
</html>
