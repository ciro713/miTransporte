$(function(){
    $.ajax({
        url: '../models/url_qr.php', // Ruta al archivo PHP que devuelve el id_usuario o DNI del usuario
        type: 'GET',
        success: function(res){
            var id_usuario = res.trim(); // Asegúrate de quitar espacios en blanco
            console.log(id_usuario);

            // Construir la URL con el id_usuario
            var urlPerfilAlumno = "http://localhost/miTransporte/src/views/perfil.php?id_usuario=" + id_usuario;

            // Llamar a la función para generar el código QR
            generarQR(urlPerfilAlumno);
        },
        error: function(err){
            console.error("Error al obtener el id_usuario:", err);
        }
    });
});

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