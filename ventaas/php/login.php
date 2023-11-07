<?php
require 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $query = "SELECT tipo_usuario, id FROM usuario WHERE correo = ? AND contrasena = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result(); 

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userType, $userID);
        $stmt->fetch();

        if ($userType === "estudiante") {
            $query2 = "SELECT rut FROM estudiante WHERE usuario_id = ?";
            $stmt2 = $con->prepare($query2);
            $stmt2->bind_param("i", $userID);
            $stmt2->execute();
            $stmt2->store_result(); 
            $stmt2->bind_result($rut);

            if ($stmt2->num_rows > 0 && $stmt2->fetch()) {

                header("Location: onBoardE.php?rut=$rut");
            }
            $stmt2->close(); 
        } elseif ($userType === "administrador") {
            header("Location: onBoardAdmin.php");
        } elseif ($userType === "docente") {
            $query3 = "SELECT rut FROM profesor WHERE usuario_id = ?";
            $stmt3 = $con->prepare($query3);
            $stmt3->bind_param("i", $userID);
            $stmt3->execute();
            $stmt3->store_result(); 
            $stmt3->bind_result($rut2);

            if ($stmt3->num_rows > 0 && $stmt3->fetch()) {
                header("Location: onBoardP.php?rut=$rut2");
            }
            $stmt3->close(); 
        } else {
            echo "Unknown user type.";
        }
    } else {
        echo "<script>alert('Email o contraseña inválidos.'); window.location.href = '../index.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
