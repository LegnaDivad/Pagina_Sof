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
    <title>Lista de empleados</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F0F4EF; 
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #0D1821;
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            margin: 0 auto;
            background-color: #FFFFFF; /* White for table background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #BFCC94; /* Sage */
        }

        .table th {
            background-color: #344966; /* Indigo Dye */
            color: #E6AACE; /* Lavender Pink */
            font-weight: bold;
        }

        .table tr:hover {
            background-color: #E6AACE; /* Lavender Pink */
            color: #0D1821; /* Rich Black */
        }

        .id-col {
            width: 50px;
            text-align: center;
        }

        .rol {
            text-transform: capitalize;
        }

        .new-record-btn {
            background-color: #28a745; /* Green for new record button */
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .new-record-btn:hover {
            background-color: #218838;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }

        .actions-col {
            text-align: center;
            width: 100px;
        }

        .actions-btn {
            background-color: #007bff; /* Blue for action buttons */
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .actions-btn:hover {
            background-color: #0056b3;
        }

        .actions-btn.delete {
            background-color: #dc3545; /* Red for delete button */
        }

        .actions-btn.delete:hover {
            background-color: #c82333;
        }

        #mensaje {
            color: #F00; /* Red for error messages */
            font-size: 16px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    <?php include "menu.php"; ?> 

    <div class="container">
        <a href="empleados_alta.php">
            <button class="new-record-btn">Crear nuevo registro</button>
        </a>
    </div>

    <div id="mensaje"></div>

    <?php
    require "funciones/conecta.php";

    $con = conecta();
    $sql = "SELECT * FROM empleados WHERE eliminado = 0";
    $res = $con->query($sql);
    $num = $res->num_rows;

    echo "<h1 id='empleados-header'>Listado de empleados ($num)</h1>";

    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>
            <th class='id-col'>ID</th>
            <th>Nombre Completo</th>
            <th>Correo</th>
            <th>Rol</th>
            <th class='actions-col'>Ver detalle</th>
            <th class='actions-col'>Editar</th>
            <th class='actions-col'>Eliminar</th>
          </tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $res->fetch_array()) {
        $id = $row['id'];
        $nombre = $row['nombre'];
        $apellidos = $row['apellidos'];
        $correo = $row['correo'];
        $rol = $row['rol'] == 1 ? 'Gerente' : 'Ejecutivo';
    
        echo "<tr id='fila_$id'>
                <td class='id-col'>$id</td>
                <td>$nombre $apellidos</td>
                <td>$correo</td>
                <td class='rol'>$rol</td>
                <td class='actions-col'><a href='ver_detalle.php?id=$id'><button class='actions-btn'>Ver</button></a></td>
                <td class='actions-col'><a href='empleados_edita.php?id=$id'><button class='actions-btn'>Editar</button></a></td>
                <td class='actions-col'><button class='actions-btn delete' onclick='confirmarEliminacion($id, \"$nombre $apellidos\")'>Eliminar</button></td>
              </tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
    ?>

    <script src="jquery-3.3.1.min.js"></script>
    <script>
        function confirmarEliminacion(id, nombre) {
            $("#mensaje").html(`¿Seguro que quieres eliminar a ${nombre} con ID: ${id}? <br>
                <button onclick="eliminarEmpleado(${id})">Sí</button>
                <button onclick="$('#mensaje').html('')">No</button>`);
        }

        function eliminarEmpleado(id) {
            $.ajax({
                url: 'empleados_elimina.php',
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    console.log(response);
                    if (response == 1) {
                        $("#fila_" + id).remove();
                        $("#mensaje").html('Empleado eliminado correctamente.');

                        var totalEmpleados = parseInt($("#empleados-header").text().match(/\d+/)[0]);
                        totalEmpleados--;  
                        $("#empleados-header").html(`Listado de empleados (${totalEmpleados})`);
                        
                        setTimeout(function () {
                    $("#mensaje").fadeOut("slow", function() {
                        $(this).html('').show();
                    });
                }, 3000);
                    } else {
                        $("#mensaje").html('Error al eliminar el empleado.');
                    }
                },
                error: function () {
                    $("#mensaje").html('Error en la solicitud.');
                }
            });
        }
    </script>

</body>

</html>