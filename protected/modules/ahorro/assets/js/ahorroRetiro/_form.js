var inputPersonaId;
$(function () {
    inputPersonaId = $("#AhorroRetiro_socio_id");
    inputPersonaId.select2({
        placeholder: "Seleccione un Socio",
        //multiple: true,
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/persona/ajaxlistSocios",
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });

    //chages
    inputPersonaId.on("change", function (e) {

    });
//    $("#AhorroRetiro_socio_id").change(function () {
//        var contenedor = $('#infoSocio');
//        $.ajax({
////        type: "POST",
//            url: baseUrl + 'ahorro/ahorroRetiro/ajaxInfoSocio/id/' + $(this).val(),
//            beforeSend: function () {
//                contenedor.html('');
//
//                var html = "";
//                html += "<div class='loading text-center'><img src='" + themeUrl + "images/truulo-loading.gif' /></div>";
//                contenedor.html(html);
//            },
//            success: function (data) {
//                contenedor.html('');
//                contenedor.html(data);
//
//            }
//        });
//    });
});

/**
 * Obtiene la informacion del socio y la cantidad maxima(de ahorro que ha realizado) que puede retirar
 * @param socio_id
 */
function getInfoRetiro(socio_id) {

    $.getJSON();
}
