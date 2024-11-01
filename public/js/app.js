$(function () {
    $('#Buscar').keyup(function () {
        let Buscar = $('#Buscar').val();
        $('#tabla').load('../src/models/mod.php', {
            dato: Buscar
        }, function () {

        }
        );
    });

    function cargar() {
        $.ajax({
            url: '../src/models/mod2.php',
            type: 'GET',
            success: function (res) {
                let datos = JSON.parse(res);
                let html_tab = '';
                datos.forEach(dato => {
                    if (dato.estado_credencial === 'espera_escuela') {
                        html_tab += `
                           <tr class="container-fluid">
                            <td>${dato.DNI}</td>
                            <td>${dato.nombre_apellido}</td>
                            <td><img src="../src/src/${dato.documento_frente}" class="doc-img" /></td>
                            <td><img src="../src/src/${dato.documento_reverso}" class="doc-img" /></td>
                            <td><img src="../src/src/${dato.constancia}" class="doc-img" /></td>
                            <td><img src="../src/src/${dato.alumno}" class="doc-img" /></td>
                            <td><button type="button" data_id2="${dato.estado_credencial}" class="confirmar">Confirmar</button></td>
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

    $(document).on('click', '.borrar', function () {
        let id = $(this).attr('data_id');
    
        // Mostrar alerta de confirmación
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
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
                    success: function (res) {
                        console.log(res);
                        // Mostrar el resultado con SweetAlert
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
    

    $(document).on('click', '.confirmar', function () {
        let row = $(this).closest('tr');
        let DNI = row.find('td:first').text();
        console.log('DNI a confirmar:', DNI);
        console.log('Fila a ocultar:', row);
        $.ajax({
            url: '../src/controllers/modpasar.php',
            type: 'POST',
            data: {
                id_confirmar: DNI
            },
            success: function (res) {
                console.log('Respuesta del servidor:', res);
                if (res === 'estado_cooperativa') {
                    alert('Esta tarea ha sido enviada a otra página');
                    row.hide();
                    cargar();
                } else {
                    row.hide();
                    cargar();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
                alert('Hubo un error en la solicitud AJAX: ' + error);
            }

        });

    });
                             
});

/* Resto del código permanece igual */
/* Función para mostrar u ocultar el menú desplegable */
function toggleDropdown() {
    var dropdown = document.getElementById("myDropdown");
    dropdown.classList.toggle("show");
}

/* Cerrar el menú desplegable si se hace clic fuera de él */
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}


document.getElementById('image').addEventListener('click', function () {
    this.classList.toggle('expanded');
});
