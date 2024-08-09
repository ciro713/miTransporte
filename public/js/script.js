//verifica que todos los campos esten completos antes de enviar el formilario
function validateRegistro(registro) {
    var isValid = true;
    $(".form_registro input").each(function () {
        if ($.trim($(this).val()) === "") {
            isValid = false;
            return false;
        }
    });

    if (!isValid) {
        alert("Completa todos los campos antes de continuar.");
    }

    return isValid;
}

//funcion para validar que sea un email
function isValidEmail(email_verificar) {
    // Expresión regular para validar un correo electrónico
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email_verificar);
}

//mostrar modal para cambiar la password

function modal_cambiar_password(){
    $('#loginForm').css('display','none');
    $('#registerForm').css('display','none');
    $("#modal_cambiar_password").css('display','block');
}

//volver al login para ingresar

function volver_login(){
    $('#loginForm').css('display','block');
    $('#registerForm').css('display','none');
    $("#modal_cambiar_password").css('display','none');

    $('#password').val("");
}

$(function(){
    //consulta a back.php para el inicio de sesion

    $("#btn-ingresar").click(function(){
        var datos = {
            id_usuario : $("#id_usuario").val(),
            password : $("#password").val(),
            opcion : "ingresar"
        }

        //console.log(datos);

        $.ajax({
            url : '../src/controllers/back.php',
            type : 'POST',
            dataType : 'json',
            data : datos,
            success:function(data){
                //console.log("Respuesta del servidor:", data);
                if(data.habilitado == true){
                    console.log("Acceso habilitado. Redirigiendo...");
                    window.location.href = '../src/views/perfil.php';
                }else if(data.espera == true){
                    console.log("Usuario en espera. Redirigiendo...");
                    window.location.href = '../public/espera.html';
                }else if(data.escuela == true){
                    console.log("Acceso como establecimiento educativo. Redirigiendo...");
                    window.location.href = '../public/admin_esc.html';
                }else if(data.escuelafallido == true){
                    console.log("error al ingresar la escuela");
                }else if(data.cambiar == true){
                    alert("cambiar contraseña.");

                    modal_cambiar_password();

                    $("#CUE_modal").val(datos["id_usuario"]);

                    const CUE_cambiar = datos["id_usuario"];

                    $("#btn-cambiar-password").click(function(){
                        var sendEmail = {
                            CUEmodal : CUE_cambiar,
                            obtenerPass : $("#password_escuela_cambiar").val(),
                            //opcion: 'enviar_mail'
                        }

                        //console.log(sendEmail);

                        $.ajax({
                            url : '../src/controllers/enviar_mail.php',
                            type : 'POST',
                            dataType : 'json',
                            data : sendEmail,
                            success:function(data){
                                if(data.enviado){
                                    $(".input-token").css('display','block');
                                    $("#btn-cambiar-password").css('display','none');

                                    $("#btn-enviar-token").click(function(){
                                        var sendToken = {
                                            token : $("#token").val(),
                                            CUE_token : CUE_cambiar,
                                            new_password : sendEmail.obtenerPass,
                                            //opcion : "verificar_token"
                                        }

                                        $.ajax({
                                            url : '../src/models/verificar_token.php',
                                            type : 'POST',
                                            dataType : 'json',
                                            data : sendToken,
                                            success:function(data){
    
                                                //console.log("respuesta del servidor", data);
                                                if(data.exito){
                                                    alert("cambio con exito");
                                                    volver_login();
                                                    
                                                }else if(data.error){
                                                    alert("no se cambio correctamente");
                                                }
    
                                            },
                                            error:function(xhr, status, error){
                                                console.log("Error en la solicitud:", error);
                                                alert("Ha ocurrido un error al procesar la solicitud");
                                            }
                                        })
                                    })

                                }else if(data.error){
                                    console.log("respuesta del servidor", data);
                                }

                            },
                            error:function(xhr, status, error){
                                console.log("Error en la solicitud:", error);
                                alert("Ha ocurrido un error al procesar la solicitud");
                            }
                        })
                    })

                }else if(data.cooperativa == true){
                    console.log("Acceso como cooperativa. Redirigiendo...");
                    window.location.href = '../public/admin.html';
                }else if(data.invalido == true){
                    console.log("Usuario inválido.");
                    alert("Usuario inválido");
                }
            },
            error:function(xhr, status, error){
                console.log("Error en la solicitud:", error);
                alert("Ha ocurrido un error al procesar la solicitud");
            }
        })
    })

    //consulta a back.php para el registro del usuario
    $("#btn-registrar").click(function(){

        //llama a ala funcion para verificar que los campos del formulario esten completos
        if (!validateRegistro()) {
            return false;
        }

        //verificacion del email
        var email_verificar = $("#email").val();
        if (!isValidEmail(email_verificar)) {
            alert("Por favor, introduce una dirección de correo electrónico válida.");
            return false;
        }

        //comprueba que el input para el DNI contenga 8 numeros
        var dni = $("#DNI_registro").val();
        var dniPattern = /^\d{8}$/; // Expresión regular para validar 8 números

        if (!dniPattern.test(dni)) {
            alert("El DNI debe contener exactamente 8 números.");
            $(this).val("");
            return;
        }

        //comienza a obtener los datos del formulario para cargar en la bdd
        var estudiante = new FormData($(".form_registro")[0]);

        estudiante.append('nombre_apellido', $("#nombre_apellido").val());
        estudiante.append('id_usuario', $("#DNI_registro").val());
        estudiante.append('password', $("#password_registro").val());
        estudiante.append('email', $("#email").val());
        estudiante.append('direccion', $("#direccion").val());
        estudiante.append('desde', $("#desde").val());
        estudiante.append('hasta', $("#hasta").val());
        estudiante.append('establecimiento_educativo', $("#establecimiento_educativo").val());
        estudiante.append('opcion', 'registrarse');

        $("input[name='colectivos[]']:checked").each(function() {
            estudiante.append('colectivos[]', $(this).val());
        });

        estudiante.forEach((value, key) => {
            console.log(key, value);
        });

        $.ajax({
            url: '../src/controllers/back.php',
            type: 'POST',
            data: estudiante,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log("Respuesta del servidor:", data);
        
                try {
                    // Si la respuesta no es ya un objeto JSON, descomentar la línea siguiente:
                    const response = JSON.parse(data);
        
                    if (response.exito) {
                        window.location.href = '../public/espera.html';
                    } else if (response.fallido) {
                        console.log("Error en el registro:", response.mensaje);
                        alert("Error en el registro: " + response.mensaje);
                    } else if (response.duplicado) {
                        alert("Ya existe un usuario registrado con ese DNI");
                    } else {
                        console.log("Respuesta inesperada del servidor:", response);
                    }
        
                    if (response.relacion_exito) {
                        console.log("Relación creada");
                    } else if (response.relacion_fallido) {
                        console.log("Relación fallida");
                    }
                } catch (error) {
                    console.error("Error al parsear JSON:", error);
                    console.error("Respuesta recibida:", data);
                    alert("Respuesta inesperada del servidor. Ver la consola para más detalles.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud:", error);
                console.error("Estado de la solicitud:", status);
                console.error("Respuesta del servidor:", xhr.responseText);
                alert("Ha ocurrido un error al procesar la solicitud. Ver la consola para más detalles.");
            }
        });
    })
})