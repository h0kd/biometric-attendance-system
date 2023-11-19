<!DOCTYPE html>
<html>
<head>
    <title>Tabla Profesor</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
    </div>
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
                                    <td><button $disableButton onclick='iniciarClase($id, \"$rut2\")'>Iniciar Clase</button></td>
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
        <br>
    <a href="excel.php" id="btnsTable2" class="btn btn-primary float-end">Generar informe</a>
    <a href="addClase.php?rut=<?php echo $_GET['rut']; ?>" id="btnsTable2" class="btn btn-primary float-end">Agregar clase</a>


</body>
</html>


                      
                    