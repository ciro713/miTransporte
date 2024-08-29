function generarQR(urlPerfil) {
    // Vaciar el contenedor si ya existe un QR
    document.getElementById('qrcode').innerHTML = "";

    new QRCode(document.getElementById("qrcode"), {
        text: urlPerfil, // URL a la que redirigirá el QR
        width: 128, 
        height: 128 
    });
}

var urlPerfilAlumno = "https://www.youtube.com/watch?v=aFJHEE4L1CE";

generarQR(urlPerfilAlumno);