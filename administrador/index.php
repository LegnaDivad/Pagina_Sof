<?php
require 'funciones/conecta.php';
$con = conecta();

session_start();  
if (isset($_SESSION['idUser'])) {
    header("Location: bienvenidoEmpleado.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Exclusivo</title>
    <link href="https://fonts.googleapis.com/css2?family=Cardo:wght@700&family=Raleway:wght@300&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #F0F4EF;
            /* Baby Powder */
            font-family: 'Raleway', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #E6AACE;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            font-family: 'Cardo', serif;
            color: #344966;
            /* Indigo Dye */
            font-size: 2rem;
            margin-bottom: 30px;
        }

        label {
            display: block;
            color: #0D1821;
            /* Rich Black */
            font-weight: 600;
            margin-bottom: 5px;
            text-align: left;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #BFCC94;
            color: #fff;
            font-weight: bold;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #A8B78A;
        }

        #mensaje {
            margin-top: 20px;
            font-size: 0.9rem;
            color: red;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function validarFormulario() {
            // Obtener valores de los campos
            var correo = $('#correo').val();
            var pass = $('#pass').val();
            var mensaje = '';

            // Validar que los campos no estén vacíos
            if (correo === '' || pass === '') {
                mensaje = 'Por favor, llene todos los campos.';
                $('#mensaje').html(mensaje).css('color', 'red');
                return false;
            } else {
                $.ajax({
                    url: 'verificarEmpleado.php',
                    type: 'POST',
                    data: { correo: correo, pass: pass },
                    success: function (response) {
                        console.log(response);
                        if (response == 0) {
                            mensaje = 'El usuario no existe o está inactivo.';
                            $('#mensaje').html(mensaje).css('color', 'red');
                        } else {
                            window.location.href = 'bienvenidoEmpleado.php';
                        }
                    },
                    error: function () {
                        $('#mensaje').html('Error al procesar la solicitud.').css('color', 'red');
                    }
                });
                return false; // Prevenir el envío normal del formulario
            }
        }
    </script>

</head>


<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form onsubmit="return validarFormulario();">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" style="width:90%">

            <label for="pass">Contraseña:</label>
            <input type="password" id="pass" name="pass" style="width:90%">

            <input type="submit" value="Iniciar Sesión">

            <div id="mensaje"></div>
        </form>
    </div>
</body>

</html>