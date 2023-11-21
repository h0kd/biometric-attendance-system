<!DOCTYPE html>
<html>
<head>
    <title>Tabla Estudiante</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9a45125b50.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="containerBanner">
        <div class="banner">
            <div class="banner-text">
                <a href="onBoardE.php"><img id="logoUsm" src="../assets/logoUsm.png"></a>
            </div>
        </div>
    </div>
    <div class="container">
        
        <div class="table-container">
            <h1 id="h1Tabla">Tabla de Busqueda</h1>
            <table border="1" id="tabla-personalizada" class"table">
                <thead>
                    <tr>
                        <th>Clase</th>
                        <th>Fecha y hora</th>
                        <th>Atrasos</th>
                    </tr>
                </thead>
                <tbody id="tablaBody">
                    
                <?php
                require 'dbcon.php';
                $rut = $_GET['rut'];
                if ($con->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT a.clase_id, a.fecha, a.atraso FROM asistencia a WHERE a.estudiante_rut = '$rut'";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $clase_id = $row['clase_id'];
                        $fecha = $row['fecha'];
                        $atraso = $row['atraso'];
                        echo "<tr><td>$clase_id</td><td>$fecha</td><td>$atraso</td></tr>";
                    }
                } else {
                    echo "0 results";
                }
                $con->close();
                ?>
                </tbody>
            </table>
        </div>

        <div class="buttons-container">
        <a href="excelE.php?rut=<?php echo $_GET['rut']; ?>" id="btnsTable2" class="btn btn-success float-end">Generar informe</a>
        <button id="regresarBtnForm" class="btn btn-danger float-end">Regresar</button>
        </div>

    </div>
    <script>
        // Función para regresar a la página anterior
        document.getElementById('regresarBtnForm').addEventListener('click', function() {
            history.back();
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
          <p>Deinacrida nace como una agrupación con el objetivo de agilizar a disposición de los estudiantes y profesores para realizar sus clases.</p>
          <p>La finalidad de nuestro trabajo es la optimización de los tiempos para aprovechar al máximo los periodos de formación académica y aportar en la formación de profesionales de distintas áreas de estudio.</p>
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
