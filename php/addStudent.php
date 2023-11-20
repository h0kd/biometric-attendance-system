<?php
require 'dbcon.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rut = $_POST['rut'];
    $huella_dactilar = $_POST['huella_dactilar'];

    $sqlUsuario = "INSERT INTO usuario (tipo_usuario, nombre, correo, contrasena) VALUES ('estudiante', '$nombre', '$correo', '$contrasena')";
    if ($con->query($sqlUsuario) === TRUE) {
        $usuario_id = $con->insert_id;

        $sqlEstudiante = "INSERT INTO estudiante (rut, huella_dactilar, usuario_id) VALUES ('$rut', $huella_dactilar, $usuario_id)";
        if ($con->query($sqlEstudiante) === TRUE) {
            echo "Estudiante agregado exitosamente.";
        } else {
            echo "Error al agregar el estudiante: " . $con->error;
        }
    } else {
        echo "Error al agregar el usuario: " . $con->error;
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Inserción de Estudiante</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="containerBanner">
        <div class="banner">
            <div class="banner-text">
                <a href="onBoardAdmin.php"><img id="logoUsm" src="../assets/logoUsm.png"></a>
            </div>
        </div>
    </div>

    <h2 id="h2Add">Agregar Estudiante</h2>
    <form action="" method="post" id="formAdd">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre"><br><br>
        <label for="correo">Correo:</label><br>
        <input type="text" id="correo" name="correo"><br><br>
        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena"><br><br>
        <label for="rut">RUT:</label><br>
        <input type="text" id="rut" name="rut"><br><br>
        <label for="huella_dactilar">Huella Dactilar:</label><br>
        <input type="number" id="huella_dactilar" name="huella_dactilar"><br><br>
        <input type="submit" value="Agregar Estudiante" class="btn btn-success" id="btnsTable2">
    </form>
    <button id="regresarBtnForm" class="btn btn-danger">Regresar</button>

    <script>
        // Función para redirigir a onBoardAdmin.php
        document.getElementById('regresarBtnForm').addEventListener('click', function() {
            window.location.href = 'onBoardAdmin.php';
        });
    </script>
</body>
</html>
