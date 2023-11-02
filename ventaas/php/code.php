<?php
session_start();
require 'dbcon.php';

if(isset($_POST['add_student']))
{
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $asistencia = mysqli_real_escape_string($con, $_POST['asistencia']);

    $query = "INSERT INTO usuario (nombre) VALUES ('$nombre')";
    $query = "INSERT INTO asistencia (asistencia) VALUES ('$asistencia')";
    // $query = "INSERT INTO clase (clase) VALUES ('$clase')";
    
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Estudiante creado!";
        header("Location: addStudent.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Estudiante no creado.";
        header("Location: addStudent.php");
        exit(0);
    }
}

?>