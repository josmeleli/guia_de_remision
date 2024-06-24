$(document).ready(function(){
    $('#consultarBtn').click(function(){
        var ruc = $('#rucInput').val();
        var token = $(this).data('token');
        var apiUrl = 'https://dniruc.apisperu.com/api/v1/ruc/' + ruc + '?token=' + token;

        // Realiza la solicitud AJAX
        $.ajax({
            url: apiUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#razonSocialInput').val(response.razonSocial);
                $('#direccionInput').val(response.direccion);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error al realizar la consulta a la API de RUC');
            }
        });
    });
});


/* Codigo para realizar la consulta a API SUNAT con resultados automaticos (sin la necesidad de boton CONSULTAR)*/
$(document).ready(function(){
    $('#rucDos').on('input', function(){
        var ruc = $(this).val();
        var token = $(this).data('token');
        if(ruc.length === 11){
            var apiUrl = 'https://dniruc.apisperu.com/api/v1/ruc/' + ruc + '?token=' + token;

            // Realiza la solicitud AJAX
            $.ajax({
                url: apiUrl,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#razonSocialDos').val(response.razonSocial);
                    // Puedes añadir más campos aquí si es necesario
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error al realizar la consulta a la API de RUC');
                }
            });
        }
    });
});