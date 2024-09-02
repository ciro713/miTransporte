$(function(){
    $.ajax({
        url: '../models/url_qr.php', // Ruta al archivo PHP que devuelve el id_usuario o DNI del usuario
        type: 'GET',
        success: function(res){
            var id_usuario = res.trim(); // Asegúrate de quitar espacios en blanco

            // Construir la URL con el id_usuario
            var urlPerfilAlumno = "http://localhost/miTransporte/src/views/perfil.php?id_usuario=" + id_usuario;

            // Llamar a las funciones para generar los códigos QR en los dos contenedores
            generarQR('#qrcode', urlPerfilAlumno, 110, 110); // QR pequeño
            generarQR('#qrcode2', urlPerfilAlumno, 400, 400); // QR grande
        },
        error: function(err){
            console.error("Error al obtener el id_usuario:", err);
        }
    });
});

function generarQR(elementId, urlPerfil, width, height) {
    // Crear un nuevo QR
    new QRCode(document.querySelector(elementId), {
        text: urlPerfil, // URL a la que redirigirá el QR
        width: width, // Ancho del QR
        height: height // Altura del QR
    });

    // Esperar un momento para que el QR se genere completamente antes de agregar el logo
    setTimeout(() => {
        agregarLogoAlQR(elementId);
    }, 500);
}

function agregarLogoAlQR(elementId) {
    const qrcodeElement = document.querySelector(elementId + ' img');
    const logoSrc = '../../public/img/pngwing.com (13).png'; // Reemplaza con la ruta al logo que quieras agregar

    if (!qrcodeElement) return;

    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    const qrWidth = qrcodeElement.width;
    const qrHeight = qrcodeElement.height;

    // Configurar el canvas al tamaño del QR
    canvas.width = qrWidth;
    canvas.height = qrHeight;

    // Dibujar el QR en el canvas
    context.drawImage(qrcodeElement, 0, 0, qrWidth, qrHeight);

    // Cargar el logo y dibujarlo sobre el QR
    const logo = new Image();
    logo.src = logoSrc;
    logo.onload = function() {
        const logoSize = qrWidth * 0.4; // Tamaño del logo (20% del tamaño del QR)
        const logoX = (qrWidth - logoSize) / 2; // Centrar el logo horizontalmente
        const logoY = (qrHeight - logoSize) / 2; // Centrar el logo verticalmente

        // Dibujar el logo en el centro del QR
        context.drawImage(logo, logoX, logoY, logoSize, logoSize);

        // Reemplazar el código QR original con el nuevo que incluye el logo
        const qrWithLogo = document.querySelector(elementId);
        qrWithLogo.innerHTML = ''; // Limpiar el contenedor anterior
        const img = document.createElement('img');
        img.src = canvas.toDataURL();
        qrWithLogo.appendChild(img);
    };
}