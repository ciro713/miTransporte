// Generar el QR con la URL del perfil del alumno
function generarQR(urlPerfil) {
    // Vaciar el contenedor si ya existe un QR
    document.getElementById('qrcode').innerHTML = "";

    // Crear un nuevo QR
    new QRCode(document.getElementById("qrcode"), {
        text: urlPerfil, // URL a la que redirigirá el QR
        width: 128, // Ancho del QR
        height: 128 // Altura del QR
    });
}

// Ejemplo de uso: generar un QR con la URL del perfil del alumno
var urlPerfilAlumno = "https://www.youtube.com/watch?v=aFJHEE4L1CE";

generarQR(urlPerfilAlumno);