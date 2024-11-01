$(function(){
    $('#Buscar').keyup(function(){
        let Buscar=$('#Buscar').val();
        $('#tabla').load('../src/models/mod.php',{
        dato:Buscar
        },function(){
            
        }
        );
    });   

    function cargar() {
        $.ajax({
            url: '../src/models/mod3.php',
            type: 'GET',
            success: function(res) {
                let datos = JSON.parse(res);
                let html_tab = '';
                datos.forEach(dato => {
                    if (dato.estado_credencial === 'espera_cooperativa') {
                        html_tab += `
                            <tr class="container-fluid">
                            <td>${dato.DNI}</td>
                            <td>${dato.nombre_apellido}</td>
                            <td><img src="../src/src/${dato.documento_frente}" class="doc-img" /></td>
                            <td><img src="../src/src/${dato.documento_reverso}" class="doc-img" /></td>
                            <td><img src="../src/src/${dato.constancia}" class="doc-img" /></td>
                            <td><img src="../src/src/${dato.alumno}" class="doc-img" /></td>
                            <td><button type="button" data_id2="${dato.estado_credencial}"  data_id="${dato.DNI}" class="confirmar">Confirmar</button></td>
                            <td><button type="button" data_id="${dato.DNI}" class="borrar">Borrar</button></td>
                        </tr>`;
                    }
                });
                $('#tabla').html(html_tab);
                    // Añade un evento click a todas las imágenes para expandirlas
                $('.doc-img').on('click', function() {
                    $(this).toggleClass('expanded');
                });
            }       
        });
    }
                                 
    cargar();

    $(document).on('click', '.confirmar', function() {
        let DNI = $(this).attr('data_id');
        $.ajax({
            url: '../src/models/mod4.php', 
            type: 'POST',
            data: { id_confirmar: DNI },
            success: function(res) {
                console.log('Respuesta cruda:', res); // Imprime la respuesta tal cual se recibe
                try {
                    let datos = JSON.parse(res);   
                    console.log('JSON parseado:', datos); // Imprime el JSON parseado
                    if (datos.habilitado) {
                        // Reemplaza alert por SweetAlert
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: "El estado de la credencial ha sido actualizado a 'habilitado'"
                        });
                        cargar();
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: datos.message || 'Hubo un error al actualizar el estado de la credencial'
                        });
                        console.log("respuesta: ", datos);
                    }
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    // SweetAlert en caso de error de parsing
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Ocurrió un error al procesar la respuesta del servidor."
                    });
                }
            }
        });
    });
    
    

    $(document).on('click', '.borrar', function() {
        let id = $(this).attr('data_id');
    
        // Mostrar alerta de confirmación
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00ff00",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminarlo",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, procede con la solicitud AJAX
                $.ajax({
                    url: '../src/controllers/modborrar.php',
                    type: 'POST',
                    data: {
                        id_borrar: id
                    },
                    success: function(res) {
                        console.log(res);
                        if (res == '1') {
                        } else {
                            Swal.fire({
                                title: "¡Eliminado!",
                                text: "El usuario ha sido eliminado correctamente.",
                                icon: "success"
                            });
                            cargar();
                        }
                    }
                });
            }
        });
    });
    
});