//funcion del boton crear mi cuenta para que aparezca el registro

$("#crear_cuenta").click(function(){
    sessionStorage.setItem('mostrarRegistro', 'true');
    window.location.href = 'public/formulario.html';
})

if(sessionStorage.getItem('mostrarRegistro') === 'true'){  
    //console.log("sessionStorage funciona");  
    $('#loginForm').css('display','none');
    $('#registerForm').css('display','block');
    sessionStorage.removeItem('mostrarRegistro');
} else {
    $("#loginForm").css('display','block');
    $("#registerForm").css('display','none');
    //console.log("sessionStorage no funciona");
}

//alternar entre mostrar y ocultar registro y login

$("#registrarse").click(function(){
    $('#loginForm').css('display','none');
    $('#registerForm').css('display','block');
})

$("#showLogin").click(function(){
    $("#loginForm").css('display','block');
    $("#registerForm").css('display','none');
})

$(function(){
    //btn para descargar la credencial
    $('#descargarBtn').click(function() {
        html2canvas($('#credencial')[0]).then(function(canvas) {
            var link = document.createElement('a');
            link.href = canvas.toDataURL();
            link.download = 'credencial.png';
            link.click();
        });
    });

    $(".href_iniciosesion").click(function(){
        $.ajax({
            url : 'src/models/verificar_sesion.php',
            type : 'POST',
            success: function(res) {
                try {
                    console.log("Respuesta del servidor:", res);

                    if (typeof res === "object") {
                        data = res;
                    } else {
                        data = JSON.parse(res);
                    }

                    if(data.sesionON){
                        window.location.href = 'src/views/perfil.php';
                    } else if(data.sesionOFF){
                        window.location.href = 'public/formulario.html';
                    }
                } catch (e) {
                    console.error("Error al parsear JSON:", e, res);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            }
        });
    });

    $(".cerrar_sesion").click(function(){
        $.ajax({
            url : '../controllers/cerrar_sesion.php',
            type : 'POST',
            success: function(res) {
                console.log("Respuesta del servidor:", res);
                
                window.location.href = '../../index.html';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            }
        });
    })

    $(".enviar_alerta").click(function(){
        var content  = {
            titulo : $("#newTitle").val(),
            contenido : $("#newContent").val()
        }

        $.ajax({
            url : "../controllers/guardar_notificacion.php",
            type : "POST",
            dataType : "json",
            data : content,
            success:function(data){

            }
        })
    })
});