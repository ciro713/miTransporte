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
                
                if (res === '1') {
                    alert('El estado de la credencial ha sido actualizado a "habilitado"');
                   
                    cargar();
                    
                } else if(res === '0'){
                    alert('Hubo un error al actualizar el estado de la credencial');
                    console.log("respuesta: ", res);
                }
            }
        });
    });

    $(document).on('click','.borrar',function(){
        let id=$(this).attr('data_id'); 
        //console.log($(this)); 
        $.ajax({
            url: '../src/controllers/modborrar.php',
            type: 'POST',
            data: {
                id_borrar:id
            }, success: function (res) {
               console.log(res);
                if (res=='1'){
                   alert('Eliminado correctamente');
                   cargar();
                   
                } else {
                   alert('error al eliminar');
                   cargar();
                }    
            }    
        });
    })
});