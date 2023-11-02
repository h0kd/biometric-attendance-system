<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Tabla de Búsqueda</title>
    <script src="functions.js"></script>
</head>
<body>
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
            <!-- Aquí se mostrarán los datos de la tabla -->
            <td><a href="javascript:void(0);" onclick="mostrarInfo('Nombre1')" style="display: none;">Nombre1</a></td>
        </tbody>
    </table>
    <br>
    <button onclick="agregarFila()" id="btnAdd" class="buttonsTable">Agregar</button>
    <button onclick="refrescarTabla()" id="btnRefresh" class="buttonsTable">Refrescar</button>
    <script>
        // Función para agregar una fila a la tabla
        function agregarFila() {
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
        }



        // Función para refrescar la tabla (borra todas las filas)
        function refrescarTabla() {
            var tablaBody = document.getElementById("tablaBody");
            while (tablaBody.firstChild) {
                tablaBody.removeChild(tablaBody.firstChild);
            }
        }
    </script>
</body>
</html>
