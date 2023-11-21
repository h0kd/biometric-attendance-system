<?php
$rut = $_GET['rut'];
require 'dbcon.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($con->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $fecha = $_POST['fecha'];
    $clase_id = $_POST['clase_id'];
    $estudiante_rut = $_POST['estudiante_rut'];
    $asistencia = $_POST['asistencia'];
    $atraso = $_POST['atraso'];

    if (date_create($fecha) === false) {
        echo "Error: El formato de fecha no es válido.";
        $con->close();
        exit;
    }

    $estudianteCheckQuery = "SELECT rut FROM estudiante WHERE rut = '$estudiante_rut'";
    $result = $con->query($estudianteCheckQuery);

    if ($result->num_rows === 0) {
        echo "Error: El estudiante con el RUT proporcionado no existe en la base de datos.";
        $con->close();
        exit;
    }

    $sql = "INSERT INTO asistencia (fecha, clase_id, estudiante_rut, asistencia, atraso) VALUES ('$fecha','$clase_id', '$estudiante_rut', '$asistencia', '$atraso')";

    if ($con->query($sql) === TRUE) {
        echo "Nueva asistencia insertada con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Inserción de Asistencia</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9a45125b50.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="containerBanner">
        <div class="banner">
            <div class="banner-text">
                <a href="#"><img id="logoUsm" src="../assets/logoUsm.png"></a>
            </div>
        </div>
    </div>

    <form action="" method="post" id="formInsert">
        <label for="estudiante_rut">RUT del Estudiante:</label><br>
        <input type="text" id="estudiante_rut" name="estudiante_rut" readonly><br><br>
        <label for="fecha">Fecha y Hora (Formato: YYYY-MM-DD HH:MM:SS):</label><br>
        <input type="text" id="fecha" name="fecha"><br><br>
        <label for="clase_id">ID clase:</label><br>
        <input type="text" id="clase_id" name="clase_id"><br><br>
        <label for="asistencia">Asistencia (1 para presente, 0 para ausente):</label><br>
        <input type="text" id="asistencia" name="asistencia"><br><br>
        <label for="atraso">Atraso (1 para atraso, 0 para puntualidad):</label><br>
        <input type="text" id="atraso" name="atraso"><br><br>
        <input type="submit" value="Enviar" class="btn btn-success" id=btnsTable2>
        <script>
            document.getElementById('estudiante_rut').value = "<?php echo $rut; ?>";
        </script>
    </form>
    <button id="regresarBtnForm" class="btn btn-danger" >Regresar</button>

    <script>
        // Función para redirigir a onBoardAdmin.php
        document.getElementById('regresarBtnForm').addEventListener('click', function() {
            window.location.href = 'onBoardAdmin.php';
        });
    </script>

    <!-- Footer -->
    <footer class="pie-pagina">
      <div class="grupo-1">
        <div class="box">
          <figure>
            <a href="#">
              <img src="../assets/deinacrida.png" alt="Logo del footer">
            </a>
          </figure>
        </div>
        <div class="box">
          <h2>SOBRE NOSOTROS</h2>
          <p>Texto de ejemplo con mucho ejemplo para que no quede vacio xdd</p>
          <p>Texto de ejemplo numero 2 con mucho ejemplo con el anterior xdd</p>
        </div>
        <div class="box">
          <h2>CONTACTO</h2>
          <div class="red-social">
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-instagram"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-youtube"></a>
          </div>
        </div>
      </div>
      <div class="grupo-2">
        <small>&copy; 2023 <b>Deinacrida</b> - Todos los Derechos Reservados.</small>
      </div>
    </footer>

</body>
</html>
