<?php
session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffcccc; /* Color rosa */
            margin: 0;
            padding: 0;
        }

        .formulario {
            position: absolute;
            top: 0;
            left: 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: white;
        }

        input[type="submit"] {
            background-color: #ff4081; /* Color rosa fuerte */
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #d81b60; 
        }

        #mensaje {
            color: grey;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
            display: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="formulario">
        <form id="loginForm">
            <input type="text" name="correo" id="correo" placeholder="Usuario">
            <input type="password" name="pass" id="pass" placeholder="Contraseña">
            <input type="submit" value="Ingresar">
        </form>
        <div id="mensaje"></div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault(); 
                var correo = $('#correo').val();
                var pass = $('#pass').val();

                if (correo === '' || pass === '') {
                    $('#mensaje').html('Faltan datos').show();
                    setTimeout(function() {
                        $('#mensaje').hide();
                    }, 5000);
                } else {
                    var formData = $(this).serialize();
                    $.post('validar.php', formData, function(response) {
                            
                        if (response.trim() === "success") {
                            window.location.href = 'bienvenido.php';
                        } else {
                            $('#mensaje').html('Datos incorrectos').show();
                            setTimeout(function() {
                                $('#mensaje').hide();
                            }, 5000);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
