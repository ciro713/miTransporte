//funcion para consultar las localidades y traerlas al formulario
function obtenerLocalidades() {
    $.ajax({
        url: '../src/models/filtro_localidades.php',
        method: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success == true) {
                var localidades = response.localidades;

                // Agregar cada localidad como una opción al select
                $.each(localidades, function(index, localidad) {
                    $('#desde').append($('<option>', {
                        value: localidad.id_localidad,
                        text: localidad.localidad
                    }));

                    $('#hasta').append($('<option>', {
                        value: localidad.id_localidad,
                        text: localidad.localidad
                    }));
                });
            } else {
                console.log('Error al obtener las localidades.');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error en la solicitud AJAX: ' + status + ' - ' + error);
        }
    });
}

//funcion para consultar las escuelas y traerlas al formulario
function obtenerEscuelas() {
    $.ajax({
        url: '../src/models/filtro_escuelas.php',
        method: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success == true) {
                var escuelas = response.escuelas;

                // Agregar cada localidad como una opción al select
                $.each(escuelas, function(index, establecimiento_educativo) {
                    $('#establecimiento_educativo').append($('<option>', {
                        value: establecimiento_educativo.id_establecimiento_educativo,
                        text: establecimiento_educativo.establecimiento_educativo
                    }));
                });
            } else {
                console.log('Error al obtener las escuelas.');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error en la solicitud AJAX: ' + status + ' - ' + error);
        }
    });
}

$(function(){
    //llamar a la funcion para obtener las escuelas al cargar la pagina
    obtenerEscuelas();

    // Llamar a la función para obtener las localidades al cargar la página
    obtenerLocalidades();
})