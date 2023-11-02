<?php
// This is a simplified example. You should use prepared statements and additional security measures to protect against SQL injection.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to your database (replace with your database credentials)
    $conn = new mysqli("localhost","root","","deinacridadb");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to check user credentials and get user type
    $query = "SELECT tipo_usuario FROM usuario WHERE correo = ? AND contrasena = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->bind_result($userType);

    if ($stmt->fetch()) {
        // User credentials are valid
        switch ($userType) {
            case "administrador":
                header("Location: onBoardAdmin.php");
                break;
            case "docente":
                header("Location: onBoardP.php");
                break;
            case "estudiante":
                header("Location: onBoardE.php");
                break;
            default:
                echo "Unknown user type.";
                break;
        }
    } else {
        echo "<script>alert('Email invalido o contrasena.'); window.location.href = '../index.html';</script>";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... (your existing head section) -->
</head>
<body>
    <!-- ... (your existing HTML form) -->
</body>
</html>