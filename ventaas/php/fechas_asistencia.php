<?php
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    // Realiza una consulta para obtener las fechas de asistencia para el estudiante con el nombre proporcionado
    // Asegúrate de que la variable $nombre esté debidamente protegida contra inyección SQL
    // Realiza la consulta y almacena las fechas en un arreglo
    $fechasAsistencia = obtenerFechasDeAsistencia($nombre);
    // Devuelve las fechas como respuesta JSON
    echo json_encode($fechasAsistencia);
} else {
    echo 'Parametros faltantes.';
}

function obtenerFechasDeAsistencia($nombre) {
    // Variables de conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "deinacridadb";

    // Crear una conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Comprobar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Escapar el nombre del estudiante para proteger contra SQL injection
    $nombre = $conn->real_escape_string($nombre);

    // Consulta SQL para obtener las fechas de asistencia del estudiante
    $sql = "SELECT fecha FROM asistencia AS a
            INNER JOIN estudiante AS e ON a.estudiante_rut = e.rut
            INNER JOIN usuario AS u ON e.usuario_id = u.id
            WHERE u.nombre = '$nombre' AND a.asistencia = 1";

    $result = $conn->query($sql);

    $fechasAsistencia = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Almacena las fechas en el formato deseado (puede que necesites ajustar el formato)
            $fechasAsistencia[] = $row["fecha"];
        }
    }

    // Cierra la conexión a la base de datos
    $conn->close();

    return $fechasAsistencia;
}