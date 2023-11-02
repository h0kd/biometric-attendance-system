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
                <a href="onBoardAdminV2.php"><img id="logoUsm" src="../assets/logoUsm.png"></a>
            </div>
        </div>
    </div>
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
                $conn = mysqli_connect("localhost", "root", "", "deinacridadb");
                if ($conn -> connect_error) {
                    die("Conexion fallida:". $conn -> connect_error);
                }
                $sql = "SELECT * from estudiante";
                $result = $conn -> query($sql);
                if ($result -> num_rows > 0) {
                    while ($estudiante = $result->fetch_assoc()) {
                        $sql2 = "SELECT nombre from usuario where id = " . $estudiante["usuario_id"];
                        $result2 = $conn->query($sql2);
                        $usuario = mysqli_fetch_array($result2)[0];
                    
                        $sql3 = "SELECT count(*) from asistencia where estudiante_rut = " . $estudiante["rut"] . " and asistencia = 1";
                        $result3 = $conn->query($sql3);
                        $asistencia = mysqli_fetch_array($result3)[0];
                    
                        $sql4 = "SELECT count(*) from clase";
                        $result4 = $conn->query($sql4);
                        $clase = mysqli_fetch_array($result4)[0];
                    
                        $porcentaje = round(($asistencia / $clase) * 100, 2);
                        echo "<tr><td><a href='javascript:void(0);' onclick='abrirVentanaInformacion(\"$usuario\", $asistencia, $clase, $porcentaje)'>$usuario</a></td><td>$asistencia</td><td>$clase</td><td>$porcentaje%</td><td></td></tr>";
                    }                    
                    echo "</table";
                } else {
                    echo "0 resultados";
                }
                $conn -> close();
            ?>

        </tbody>
    </table>
    <br>

    <a href="excel.php" id="btnsTable2" class="btn btn-primary float-end">Generar informe</a>

    <script>
        // Función para agregar una fila a la tabla
        document.getElementById("agregarForm").addEventListener("submit", function (event) {
            event.preventDefault();

            var form = this;
            var formData = new FormData(form);

            // Envía los datos del formulario al servidor a través de AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "insert.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Procesa la respuesta JSON del servidor
                    var nuevoEstudiante = JSON.parse(xhr.responseText);

                    // Limpia el formulario
                    form.reset();

                    // Llama a la función agregarFila con los datos del nuevo estudiante
                    agregarFila(nuevoEstudiante);
                }
            };
            xhr.send(formData);
        });

        function agregarFila(estudiante) {
            var tablaBody = document.getElementById("tablaBody");
            var fila = tablaBody.insertRow();

            var nombre = prompt("Ingrese el nombre:");
            var asistencias = prompt("Ingrese el número de asistencias:");
            var diasTotales = prompt("Ingrese los días totales:");
            var porcentajeTotal = prompt("Ingrese el porcentaje total:");

            var tablaBody = document.getElementById("tablaBody");
            var fila = tablaBody.insertRow();

            // Mostrar la columna "Nombre" cuando se agrega una fila
            document.querySelector("th").style.display = "table-cell";

            var cellNombre = fila.insertCell(0);
            var cellAsistencias = fila.insertCell(1);
            var cellDiasTotales = fila.insertCell(2);
            var cellPorcentajeTotal = fila.insertCell(3);
            var cellAccion = fila.insertCell(4);

            // Crear un enlace para el nombre
            var enlaceNombre = document.createElement("a");
            enlaceNombre.href = "javascript:void(0);"; // JavaScript void para evitar que se cargue una nueva página
            enlaceNombre.textContent = nombre;

            // Agregar el evento onclick al enlace
            enlaceNombre.onclick = function() {
                abrirVentanaInformacion(nombre, asistencias, diasTotales, porcentajeTotal);
            };

            // Agregar el enlace al contenido de la celda
            cellNombre.appendChild(enlaceNombre);

            cellAsistencias.innerHTML = asistencias;
            cellDiasTotales.innerHTML = diasTotales;
            cellPorcentajeTotal.innerHTML = porcentajeTotal;

            // Agregar un botón de eliminar
            var botonEliminar = document.createElement("button");
            botonEliminar.className = "boton-eliminar"; // Aplicar la clase CSS al botón de eliminación
            botonEliminar.innerHTML = "Eliminar";
            botonEliminar.onclick = function() {
                eliminarFila(fila);
            };
            cellAccion.appendChild(botonEliminar);
        }

        // Función para abrir la ventana de información (código previamente proporcionado)
        function abrirVentanaInformacion(nombre, asistencias, diasTotales, porcentajeTotal) {
            // Crear una nueva ventana o pestaña con información detallada
            var ventanaInformacion = window.open("", "InformacionDetallada", "width=400,height=300");

            // URL de la imagen de perfil (sustituye con la URL de la imagen deseada)
            var urlImagenPerfil = "https://i.imgur.com/pQ6jEXn.jpg"; 

            // Crear el contenido de la ventana
            var contenidoVentana = `
                <html>
                <head>
                    <title>Información Detallada</title>
                </head>
                <body>
                    <h1 style="font-family: Poppins">Información de ${nombre}</h1>
                    <img src="${urlImagenPerfil}" alt="Foto de perfil" width="100">
                    <p style="font-family: Poppins">Asistencias: ${asistencias}</p>
                    <p style="font-family: Poppins">Días totales: ${diasTotales}</p>
                    <p style="font-family: Poppins">Porcentaje total: ${porcentajeTotal}</p>
                    <!-- Puedes agregar más información aquí -->
                </body>
                </html>
            `;
            
            // Escribir el contenido en la ventana
            ventanaInformacion.document.write(contenidoVentana);
            ventanaInformacion.document.close();
        }

    </script>
</body>
</html>