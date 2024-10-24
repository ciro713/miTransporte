$(function(){
    $('#btn-enviar-dni').on('click', function(){
        /*var 
        console.log("DNI enviado:", dni); // Verificar el DNI en la consola*/

        var datos ={
            dni : $('#dni').val(),
            opcion : 'enviar'
        }
        $.ajax({
            url: '../src/models/mail_recover_pass.php',
            type: 'POST',
            data: datos,
            success: function(response){
                console.log("Respuesta del servidor:", response); // Verificar la respuesta del servidor
                if(response.success == true){
                    alert('Se ha enviado un correo para reestablecer tu contraseña.');
                } else if(response.success == false){
                    alert('Hubo un error al enviar el correo.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
            }
        });
    });    

    $('#btn-reestablecer').on('click', function(){
        var newPassword = $('#new-password').val();
        var confirmPassword = $('#confirm-password').val();
        var token = $('#reset-token').val(); // Obtener el token del campo oculto
    
        if (newPassword === confirmPassword) {
            $.ajax({
                url: '../src/models/reestablecer_pass.php',
                type: 'POST',
                dataType : 'json',
                data: {
                    token: token, // Enviar el token
                    new_password: newPassword
                },
                success: function(response) {
                    console.log('Respuesta del servidor (sin parsear):', response);
                    if (response.success) {
                        alert('Tu contraseña ha sido reestablecida.');
                        window.location.href = '../public/formulario.html';
                    } else {
                        alert('Hubo un error al reestablecer la contraseña: ' + response.message);
                        //agregar mensaje de error
                    }
                    /*try {
                        response = JSON.parse(response); // Intentar parsear la respuesta como JSON
    
                        if (response.success) {
                            alert('Tu contraseña ha sido reestablecida.');
                        } else {
                            alert('Hubo un error al reestablecer la contraseña: ' + response.message);
                        }
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        console.log('Respuesta del servidor:', response);
                        alert('Ocurrió un error inesperado. Revisa la consola para más detalles.');
                    }*/
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', status, error);
                    console.log('Respuesta del servidor:', xhr.responseText);
                    alert('Error: ' + xhr.status + ' - ' + xhr.statusText);
                }                
            });
        } else {
            alert('Las contraseñas no coinciden.');
        }
    });
    
})