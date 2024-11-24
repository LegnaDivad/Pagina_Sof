<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Exclusivo</title>
    <link href="https://fonts.googleapis.com/css2?family=Cardo:wght@700&family=Raleway:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Raleway', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            font-family: 'Cardo', serif;
            color: #c82a54;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        label {
            display: block;
            color: #333333;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
        }

        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #000000;
            color: #ffffff;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #c82a54;
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
            const correo = $('#correo').val();
            const pass = $('#pass').val();
            if (correo === '' || pass === '') {
                $('#mensaje').html('Por favor, llene todos los campos.').css('color', 'red');
                return false;
            }

            $.ajax({
                url: 'verificarCliente.php',
                type: 'POST',
                data: { correo: correo, pass: pass },
                success: function (response) {
                    if (response == 0) {
                        $('#mensaje').html('El usuario no existe o está inactivo.').css('color', 'red');
                    } else {
                        window.location.href = 'bienvenido.php';
                    }
                },
                error: function () {
                    $('#mensaje').html('Error al procesar la solicitud.').css('color', 'red');
                }
            });

            return false;
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form onsubmit="return validarFormulario();">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo">

            <label for="pass">Contraseña:</label>
            <input type="password" id="pass" name="pass">

            <input type="submit" value="Iniciar Sesión">
            <div id="mensaje"></div>
        </form>
    </div>
</body>

</html>
