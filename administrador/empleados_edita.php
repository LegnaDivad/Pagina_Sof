<?php

session_start();  
if (!isset($_SESSION['idUser'])) {
    header("Location: index.php");
    exit();
} 

require "funciones/conecta.php";

$id = $_GET['id'] ?? '';
$con = conecta();

$sql = "SELECT * FROM empleados WHERE id = ? AND eliminado = 0";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$empleado = $result->fetch_assoc();

if (!$empleado) {
    echo "Empleado no encontrado.";
    exit;
}

$stmt->close();
$con->close();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
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

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #e74c3c;
            background-color: #fadbd8;
            padding: 10px;
            border-radius: 4px;
            margin-top: 15px;
            display: none;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #3498db;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>
    <h1>Edición de Empleado</h1>

    <form id="edit-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($empleado['id']); ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($empleado['nombre']); ?>">

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos"
            value="<?php echo htmlspecialchars($empleado['apellidos']); ?>">

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($empleado['correo']); ?>">
        <span id="email-error"></span>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="1" <?php echo ($empleado['rol'] == '1') ? 'selected' : ''; ?>>Gerente</option>
            <option value="2" <?php echo ($empleado['rol'] == '2') ? 'selected' : ''; ?>>Ejecutivo</option>
        </select>

        <label for="pass">Contraseña (dejar vacío si no desea cambiarla):</label>
        <input type="password" id="pass" name="password">

        <label for="foto">Foto (opcional):</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <div id="error-message" class="error-message"></div>

        <button type="submit">Guardar cambios</button>
    </form>

    <script>
        $(document).ready(function () {
            const originalEmail = $('#correo').val();
            let emailTimer, errorTimer;

            function checkEmail(email) {
                $.ajax({
                    url: 'check_email.php',
                    type: 'POST',
                    data: { email: email, id: $('#id').val() },
                    success: function (response) {
                        if (response === 'exists') {
                            showError($('#email-error'), `El correo ${email} ya existe.`);
                        } else {
                            $('#email-error').text('');
                        }
                    }
                });
            }

            function showError(element, message) {
                element.text(message).show();
                clearTimeout(errorTimer);
                errorTimer = setTimeout(() => element.hide(), 5000);
            }

            $('#correo').on('blur', function () {
                const email = $(this).val();
                if (email !== originalEmail) {
                    checkEmail(email);
                } else {
                    $('#email-error').text('');
                }
            });

            $('#edit-form').on('submit', function (e) {
                e.preventDefault();
                const $errorMessage = $('#error-message');
                $errorMessage.hide();

                if ($('#email-error').text()) {
                    showError($errorMessage, 'El correo ingresado ya existe.');
                    return;
                }

                $.ajax({
                    url: 'empleados_actualiza.php',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.trim() === '1') {
                            window.location.href = 'empleados_lista.php';
                        } else {
                            console.log(response);
                            showError($errorMessage, response);
                        }
                    },
                    error: function () {
                        showError($errorMessage, 'Error en la solicitud AJAX.');
                    }
                });
            });
        });
    </script>
    <a href="empleados_lista.php" class="btn-regresar">Regresar</a>
</body>

</html>