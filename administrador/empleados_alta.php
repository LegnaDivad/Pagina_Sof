<?php
session_start();  
if (!isset($_SESSION['idUser'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de empleados</title>
    
    <!-- Incluye jQuery desde un CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Estilos para el botón regresar */
        .btn-regresar {
            background-color: #0D1821;
            color: #F0F4EF;
            text-decoration: none;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            padding: 15px 25px;
            text-align: center;
            border: none;
            border-radius: 8px;
            display: inline-block;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-regresar:hover {
            background-color: #344966;
            color: #E6AACE;
        }

        .btn-regresar:active {
            background-color: #E6AACE;
            color: #0D1821;
        }

        /* Estilos generales */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        .error-msg, .email-error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            display: none; /* Ocultar los mensajes inicialmente */
        }

        .link-back {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .link-back a {
            text-decoration: none;
            color: #007bff;
        }

        .link-back a:hover {
            text-decoration: underline;
        }
    </style>
<script>
$(document).ready(function() {
    let emailWithError = '';

    $('#correo').on('blur', function() {
        var email = $(this).val();

        if (email) {
            $.ajax({
                type: "POST",
                url: "check_email.php",
                data: { correo: email },
                success: function(response) {
                    if (response.trim() === '1') {
                        $('#email-error').text('El correo ya está registrado.').show();
                        $('#enviar').prop('disabled', true); 
                        emailWithError = email; 

                        // Oculta el mensaje de error después de 5 segundos
                        setTimeout(function() {
                            $('#email-error').fadeOut();
                        }, 5000);
                    } else {
                        $('#email-error').hide();
                        $('#enviar').prop('disabled', false); // Habilitar el botón de envío
                        emailWithError = ''; // Resetea el correo con error
                    }
                },
                error: function() {
                    $('#email-error').text('Error en la verificación del correo.').show();
                    $('#enviar').prop('disabled', true); // Deshabilitar el botón en caso de error

                    // Oculta el mensaje de error después de 5 segundos
                    setTimeout(function() {
                        $('#email-error').fadeOut();
                    }, 5000);
                }
            });
        } else {
            $('#email-error').hide();
            $('#enviar').prop('disabled', false); // Habilitar el botón si el campo está vacío
        }
    });

   
    $('#enviar').on('click', function(event) {
        var email = $('#correo').val();
        
        // Si el correo es el mismo que causó el error, evita el envío y muestra el mensaje
        if (email === emailWithError) {
            event.preventDefault(); // Evita el envío del formulario
            $('#email-error').text('El correo ya está registrado.').show(); // Muestra el mensaje de error
            
            // Oculta el mensaje de error después de 5 segundos nuevamente
            setTimeout(function() {
                $('#email-error').fadeOut();
            }, 5000);
        }
    });
});
</script>


</head>

<body>
    <?php include 'menu.php'; ?>
    <h1>Alta de empleados</h1>

    <div class="form-container">
        <form id="altaEmpleado" method="POST" action="empleados_salva.php" enctype="multipart/form-data">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" required>

            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" required>
            <div class="email-error" id="email-error"></div>

            <label for="pass">Contraseña</label>
            <input type="password" id="pass" name="pass" required>

            <label for="rol">Rol</label>
            <select id="rol" name="rol" required>
                <option value="">Selecciona un rol</option>
                <option value="1">Gerente</option>
                <option value="2">Ejecutivo</option>
            </select>

            <label for="foto">Imagen (obligatorio)</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>

            <div class="error-msg" id="error-msg"></div>

            <button type="submit" id="enviar">Enviar</button>
        </form>
    </div>

    <a href="empleados_lista.php" class="btn-regresar">Regresar</a>

</body>

</html>
