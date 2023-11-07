<?php
require 'dbcon.php';

$docu = "asistencia.xls";
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=' . $docu);
header('Pragma: no-cache');
header('Expires: 0');

echo '<table border = 1>';
echo '<tr>';
echo '<th colspan=3>Reporte asistencia</th>';
echo '</tr>';
echo '<tr><th>clase</th><th>fecha</th><th>atraso</th></tr>';

// Obtener el rut del estudiante desde el parámetro GET
if (isset($_GET['rut'])) {
    $rut = $_GET['rut'];

    // Consultar las asistencias del estudiante con el rut específico
    $sql = "SELECT a.clase_id, a.fecha, a.atraso FROM asistencia a WHERE a.estudiante_rut = '$rut'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar cada asistencia en filas separadas
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['clase_id'] . '</td>';
            echo '<td>' . $row['fecha'] . '</td>';
            echo '<td>' . $row['atraso'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo "0 results";
    }
} else {
    echo "RUT no proporcionado.";
}
echo '</table>';
?>

