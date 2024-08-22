$(function(){
    $('.upload-btn').on('click', function(){
        var card = $(this).closest('.card');
        var fileInput = card.find('.file-input')[0];
        var file = fileInput.files[0];

        if (file) {
            var formData = new FormData();
            formData.append('file', file);

            // Determina el tipo de horario según la tarjeta
            var horarioTipo = (card.attr('id') === 'semana-card') ? 'semana' : 'fin-de-semana';
            formData.append('horario_tipo', horarioTipo);

            // Hacer la petición AJAX
            $.ajax({
                url: '../src/controllers/cargar_horarios.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Manejo de la respuesta
                    console.log('Archivo subido exitosamente:', response);
                    alert('Horario actualizado correctamente');
                },
                error: function(xhr, status, error) {
                    // Manejo del error
                    console.log('Error al subir el archivo:', error);
                    alert('Hubo un problema al subir el archivo. Intente nuevamente.');
                }
            });
        } else {
            alert('Por favor, selecciona un archivo antes de enviar.');
        }
    });
})