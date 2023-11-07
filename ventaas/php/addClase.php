<?php
require 'dbcon.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($con->connect_error) {
        die("Conexión fallida: " . $con->connect_error);
    }

    $profesor_rut = $_POST['profesor_rut'];
    $sala = $_POST['sala'];
    $fecha = $_POST['fecha'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fin = $_POST['horario_fin'];
    $semestre = $_POST['semestre'];
    
    function validarFormatoFecha($fecha) {
        $patron = '/^\d{4}-\d{2}-\d{2}$/';

        if (preg_match($patron, $fecha)) {
            return true;
        } else {
            return false;
        }
    }

    if (validarFormatoFecha($fecha)) {
        echo "La fecha es válida.";
    } else {
        echo "La fecha no es válida.";
    }
    
    function validarFormatoHora($hora) {
        $patron = '/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/';

        if (preg_match($patron, $hora)) {
            return true;
        } else {
            return false;
        }
    }

    if (validarFormatoHora($horario_inicio)) {
        echo "La hora es válida.";
    } else {
        echo "La hora no es válida.";
    }

    $sql = "INSERT INTO clase (profesor_rut, sala, fecha, horario_inicio, horario_fin, semestre) VALUES ('$profesor_rut', '$sala', '$fecha','$horario_inicio', '$horario_fin', '$semestre')";

    if ($con->query($sql) === TRUE) {
        echo "Nueva clase creada con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Inserción de Asistencia</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    $rut2 = $_GET['rut'];
    ?>
    <form action="" method="post" id="formAddClase">
        <label for="profesor_rut">Rut Profesor:</label><br>
        <input type="text" id="profesor_rut" name="profesor_rut"><br><br>
        <label for="sala">Sala:</label><br>
        <input type="text" id="sala" name="sala"><br><br>
        <label for="fecha">Fecha (Formato: YYYY-MM-DD):</label><br>
        <input type="text" id="fecha" name="fecha"><br><br>
        <label for="hora_inicial">Hora inicial (Formato HH:MM:SS):</label><br>
        <input type="text" id="horario_inicio" name="horario_inicio"><br><br>
        <label for="estudiante_rut">Hora Termino (Formato HH:MM:SS):</label><br>
        <input type="text" id="horario_fin" name="horario_fin"><br><br>
        <label for="semestre">Semestre:</label><br>
        <input type="text" id="semestre" name="semestre"><br><br>
        <script>
            document.getElementById('profesor_rut').value = "<?php echo $rut2; ?>";
        </script>
        <input type="submit" value="Enviar" class="btn btn-success">
    </form>
    <button id="regresarBtnForm" class="btn btn-danger">Regresar</button>

    <script>
        // Función para regresar a la página anterior
        document.getElementById('regresarBtnForm').addEventListener('click', function() {
            history.back();
        });
    </script>
</body>
</html>

