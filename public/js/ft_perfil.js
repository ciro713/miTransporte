$(function(){
    $.ajax({
        url : 'src/models/img_perfil.php',
        type : 'POST',
        success: function(res) {
            if (res.status === 'success'){
<<<<<<< HEAD
                const img_perfil = `../uploads/${res.img_estudiante}`;
                //$(".img_perfil").css('display','block')
                //$(".img_perfil").html(`<img src='${img_perfil}'/>`)
=======
                //const img_perfil = `../uploads/${res.img_estudiante}`;
                //$(".img_perfil").css('display','block')
                //$(".img_perfil").html(`<img src='${img_perfil}'/>`)
                $("#container_btns").css('display', 'none');
                //$(".texto_index").css('margin-bottom', '50px');
>>>>>>> master
            } else {
                // Muestra un mensaje de error
                //console.log(res.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        }
    });
})

