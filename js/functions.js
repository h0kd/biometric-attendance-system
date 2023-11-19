function abrirVentanaInformacion(nombre, asistencias, diasTotales, porcentajeTotal) {
    // Crear una nueva ventana o pestaña con información detallada
    var ventanaInformacion = window.open("", "InformacionDetallada", "width=400,height=300");

    // URL de la imagen de perfil (sustituye con la URL de la imagen deseada)
    var urlImagenPerfil = "https://i.imgur.com/S9AFMcO.png"; 

    // Crear el contenido de la ventana
    var contenidoVentana = `
        <html>
        <head>
            <title>Información Detallada</title>
        </head>
        <body>
            <h1 style="font-family: 'Poppins';"'>Información de ${nombre}</h1>
            <img src="${urlImagenPerfil}" alt="Foto de perfil" width="100">
            <p style="font-family: 'Poppins';">Asistencias: ${asistencias}</p>
            <p style="font-family: 'Poppins';">Días totales: ${diasTotales}</p>
            <p style="font-family: 'Poppins';">Porcentaje total: ${porcentajeTotal}</p>
            <!-- Puedes agregar más información aquí -->
        </body>
        </html>
    `;

    // Escribir el contenido en la ventana
    ventanaInformacion.document.write(contenidoVentana);
    ventanaInformacion.document.close();
}