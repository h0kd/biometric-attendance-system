<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "deinacridaDB";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $profesor_rut = $_POST['profesor_rut'];
    $sala = $_POST['sala'];
    $fecha = $_POST['fecha'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fin = $_POST['horario_fin'];
    $semestre = $_POST['semestre'];

    // $clase_id = $_POST['clase_id'];
    // $estudiante_rut = $_POST['estudiante_rut'];
    // $asistencia = $_POST['asistencia'];
    // $atraso = $_POST['atraso'];

    // Validar el formato de fecha
    // if (date_create($fecha) === false) {
    //     echo "Error: El formato de fecha no es válido.";
    //     $conn->close();
    //     exit;
    // }
    
    function validarFormatoFecha($fecha) {
        // El formato de fecha válido es "YYYY-MM-DD"
        $patron = '/^\d{4}-\d{2}-\d{2}$/';
        
        // Utilizamos la función preg_match para realizar la validación
        if (preg_match($patron, $fecha)) {
            return true; // La fecha tiene el formato correcto
        } else {
            return false; // La fecha no tiene el formato correcto
        }
    }
    
    // Ejemplo de uso
    
    if (validarFormatoFecha($fecha)) {
        echo "La fecha es válida.";
    } else {
        echo "La fecha no es válida.";
    }
    
    
        
    function validarFormatoHora($hora) {
        // El formato de hora válido es "HH:MM:SS"
        $patron = '/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/';
        
        // Utilizamos la función preg_match para realizar la validación
        if (preg_match($patron, $hora)) {
            return true; // La hora tiene el formato correcto
        } else {
            return false; // La hora no tiene el formato correcto
        }
    }

    // Ejemplo de uso
    
    if (validarFormatoHora($horario_inicio)) {
        echo "La hora es válida.";
    } else {
        echo "La hora no es válida.";
    }


    // Verificar si el estudiante existe en la base de datos
    $estudianteCheckQuery = "SELECT fecha FROM clase WHERE fecha = '$fecha'";
    $result = $conn->query($estudianteCheckQuery);

    if ($result->num_rows === 1) {
        echo "Error: El estudiante con el RUT proporcionado no existe en la base de datos.";
        $conn->close();
        exit;
    }

    $sql = "INSERT INTO clase (profesor_rut, sala, fecha, horario_inicio, horario_fin, semestre) VALUES ('$profesor_rut', '$sala', '$fecha','$horario_inicio', '$horario_fin', '$semestre')";

    if ($conn->query($sql) === TRUE) {
        echo "Nueva clase creada con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Inserción de Asistencia</title>
</head>
<body>
    <form action="" method="post">
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
        <input type="submit" value="Submit">
    </form>
</body>
</html>
