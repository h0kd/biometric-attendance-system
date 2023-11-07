<?php
require 'dbcon.php';

$docu = "asistencia.xls";
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=' . $docu);
header('Pragma: no-cache');
header('Expires: 0');

echo '<table border = 1>';
echo '<tr>';
echo '<th colspan=4>Reporte asistencia</th>';
echo '</tr>';
echo '<tr><th>nombre</th><th>asistencia</th><th>dias totales</th><th>porcentaje asistencia</th></tr>';

$sql = "SELECT * FROM estudiante";
$result = $con->query($sql);

while ($estudiante = $result->fetch_assoc()) {
    $sql2 = "SELECT nombre FROM usuario WHERE id = " . $estudiante["usuario_id"];
    $result2 = $con->query($sql2);
    $usuario = mysqli_fetch_array($result2)[0];

    $sql3 = "SELECT count(*) FROM asistencia WHERE estudiante_rut = " . $estudiante["rut"] . " AND asistencia = 1";
    $result3 = $con->query($sql3);
    $asistencia = mysqli_fetch_array($result3)[0];

    $sql4 = "SELECT count(*) FROM clase";
    $result4 = $con->query($sql4);
    $clase = mysqli_fetch_array($result4)[0];

    $porcentaje = round(($asistencia / $clase) * 100, 2);

    echo '<tr>';
    echo '<td>' . $usuario . '</td>';
    echo '<td>' . $asistencia . '</td>';
    echo '<td>' . $clase . '</td>';
    echo '<td>' . $porcentaje . '</td>';
    echo '</tr>';
}
echo '</table>';
?>   
