<!DOCTYPE html>
<html>
<head>
    <title>Tabla Profesor</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9a45125b50.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="containerBanner">
        <div class="banner">
            <div class="banner-text">
                <a href="onBoardP.php"><img id="logoUsm" src="../assets/logoUsm.png"></a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="table-container">
            <h1 id="h1Tabla">Tabla de Busqueda</h1>
            <table border="1" class="tabla-personalizada">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Asistencias</th>
                        <th>Días totales</th>
                        <th>Porcentaje total</th>
                    </tr>
                </thead>
                <tbody id="tablaBody">
                    
                    <?php
                    require 'dbcon.php';
                    $rut2 = $_GET['rut'];
                        if ($con -> connect_error) {
                            die("Conexion fallida:". $con -> connect_error);
                        }
                        $sql = "SELECT * from estudiante";
                        $result = $con -> query($sql);
                        if ($result -> num_rows > 0) {
                            while ($estudiante = $result->fetch_assoc()) {
                                $sql2 = "SELECT nombre from usuario where id = " . $estudiante["usuario_id"];
                                $result2 = $con->query($sql2);
                                $usuario = mysqli_fetch_array($result2)[0];
                            
                                $sql3 = "SELECT count(*) from asistencia where estudiante_rut = " . $estudiante["rut"] . " and asistencia = 1";
                                $result3 = $con->query($sql3);
                                $asistencia = mysqli_fetch_array($result3)[0];
                                
                                $sql_rut = "SELECT rut FROM estudiante WHERE usuario_id = " . $estudiante["usuario_id"]; 
                                $result_rut = $con->query($sql_rut);
                                $rut = "";
                                if ($result_rut->num_rows > 0) {
                                    $row_rut = $result_rut->fetch_assoc();
                                    $rut = $row_rut["rut"];
                                } else {
                                    echo "No se encontró un rut para el estudiante con el nombre $nombre.";
                                }
                            
                                $sql4 = "SELECT count(*) from clase";
                                $result4 = $con->query($sql4);
                                $clase = mysqli_fetch_array($result4)[0];
                            
                                $porcentaje = round(($asistencia / $clase) * 100, 2);
                                echo "<tr><td><a href='onBoardE.php?rut=$rut'abrirVentanaInformacion(\"$usuario\", $asistencia, $clase, $porcentaje)'>$usuario</a></td><td>$asistencia</td><td>$clase</td><td>$porcentaje%</td><td></td></tr>";
                            }                    
                            echo "</table";
                        } else {
                            echo "0 resultados";
                        }
                        $con -> close();
                    ?>
                </tbody>
        </div>
          <div class="buttons-container">
            <a href="excel.php" id="btnsTable2" class="btn btn-success float-end">Generar informe</a>
            <a href="addClase.php?rut=<?php echo $_GET['rut']; ?>" id="btnsTable2" class="btn btn-primary float-end">Agregar clase</a>
            <button id="regresarBtnForm" class="btn btn-danger float-end">Regresar</button>
        </div>
          </div>
    </div>
    <script>
        // Función para regresar a la página anterior
        document.getElementById('regresarBtnForm').addEventListener('click', function() {
            window.location.href = '../index.html';
        });
    </script>
    <br>
        <div class="table-container">
            <h1 id="h1Tabla">Tabla Clases</h1>
            <table border="1" class="tabla-personalizada">
                <thead>
                    <tr>
                        <th>ID clase</th>
                        <th>Sala</th>
                        <th>fecha</th>
                        <th>horario inicio</th>
                        <th>horario fin</th>
                        <th>iniciada</th>
                    </tr>
                </thead>
                <tbody id="tablaBody">
                    <?php
                    require 'dbcon.php';
                    $rut2 = $_GET['rut'];
                    $sql = "SELECT * FROM clase WHERE profesor_rut = '$rut2'";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                      
                        while ($clase = $result->fetch_assoc()) {
                            $id = $clase['id'];
                            $iniciada = $clase['iniciada'];
                            $disableButton = $iniciada ? 'disabled' : '';

                            echo "<tr>
                                    <td>$id</td>
                                    <td>{$clase['sala']}</td>
                                    <td>{$clase['fecha']}</td>
                                    <td>{$clase['horario_inicio']}</td>
                                    <td>{$clase['horario_fin']}</td>
                                    <td>{$clase['iniciada']}</td>
                                    <td><button class='btn btn-primary' $disableButton onclick='iniciarClase($id, \"$rut2\")'>Iniciar Clase</button></td>
                                </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "0 resultados";
                    }
                        $con -> close();
                    ?>
                    
                    <script>
                    function iniciarClase(id, rut) {
                        if (confirm('¿Está seguro de iniciar esta clase?')) {
                            window.location.href = 'iniciarClase.php?id=' + id + '&rut=' + rut;
                        }
                    }
                    </script>
                </tbody>
        </div>

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


                      
                    
