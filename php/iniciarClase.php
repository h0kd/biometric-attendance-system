<?php
require 'dbcon.php';

if ($con->connect_error) {
    die("Conexion fallida:" . $con->connect_error);
}

if (isset($_GET['id'])) {
    $claseId = $_GET['id'];
    $rut2 = $_GET['rut'];
    
    $updateSql = "UPDATE clase SET iniciada = 1 WHERE id = $claseId";
    if ($con->query($updateSql) === TRUE) {
        echo "<script>
                window.location.href = 'onBoardP.php?rut=$rut2';
            </script>";
    } else {
        echo "Error al iniciar la clase: " . $con->error;
    }
} else {
    echo "ID de clase no proporcionado.";
}

$con->close();
?>