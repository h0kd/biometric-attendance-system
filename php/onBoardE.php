<!DOCTYPE html>
<html>
<head>
    <title>Tabla Estudiante</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <table border="1" class="tabla-personalizada">
                <thead>
                    <tr>
                        <th>clase</th>
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
    </div>
    <br>

    <a href="excelE.php?rut=<?php echo $_GET['rut']; ?>" id="btnsTable2" class="btn btn-primary float-end">Generar informe</a>
    <button id="regresarBtn" class="btn btn-danger">Regresar</button>
    
    <script>
        // Función para regresar a la página anterior
        document.getElementById('regresarBtn').addEventListener('click', function() {
            history.back();
        });
    </script>

</body>
</html>