<?php
require 'dbcon.php';

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $fechasAsistencia = obtenerFechasDeAsistencia($con, $nombre);
    echo json_encode($fechasAsistencia);
} else {
    echo 'Parámetros faltantes.';
}

function obtenerFechasDeAsistencia($con, $nombre) {
    if ($con->connect_error) {
        die("Conexión fallida: " . $con->connect_error);
    }
    $nombre = $con->real_escape_string($nombre);
    $sql = "SELECT fecha FROM asistencia AS a
            INNER JOIN estudiante AS e ON a.estudiante_rut = e.rut
            INNER JOIN usuario AS u ON e.usuario_id = u.id
            WHERE u.nombre = '$nombre' AND a.asistencia = 1";
    $result = $con->query($sql);
    $fechasAsistencia = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fechasAsistencia[] = $row["fecha"];
        }
    }
    return $fechasAsistencia;
}
}