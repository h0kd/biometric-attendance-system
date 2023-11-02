<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recupera los datos del formulario
    $nombre = $_POST["nombre"];
    $asistencias = $_POST["asistencias"];
    $diasTotales = $_POST["diasTotales"];
    $porcentajeTotal = $_POST["porcentajeTotal"];

    // Realiza la inserción en la base de datos
    $conn = mysqli_connect("localhost", "root", "", "deinacridadb");
    if ($conn -> connect_error) {
        die("Conexion fallida:". $conn -> connect_error);
    }

    $sql = "INSERT INTO estudiante (nombre, asistencias, dias_totales, porcentaje_total) VALUES ('$nombre', $asistencias, $diasTotales, $porcentajeTotal)";
    $result = $conn -> query($sql);

    if ($result) {
        // Recupera el último ID insertado
        $estudianteID = mysqli_insert_id($conn);

        // Recupera los datos recién insertados para enviarlos al cliente
        $sql2 = "SELECT * FROM estudiante WHERE id = $estudianteID";
        $result2 = $conn -> query($sql2);
        $nuevoEstudiante = $result2 -> fetch_assoc();

        // Devuelve los datos como respuesta JSON
        echo json_encode($nuevoEstudiante);
    } else {
        // Manejo de errores, si es necesario
        echo json_encode(array("error" => "Ocurrió un error en la inserción"));
    }

    $conn -> close();
}
?>
