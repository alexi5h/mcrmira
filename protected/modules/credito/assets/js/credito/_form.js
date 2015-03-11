var inputSocioId, inputGaranteId;
$(function () {
    inputSocioId = $('#Credito_socio_id');
    //select2
    inputSocioId.select2({
        placeholder: "Seleccione un Socio",
        multiple: false,
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
                    search_value: term, // search term
                    credito_socio: true
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });
    inputGaranteId = $('#Credito_garante_id');
    //select2
    inputGaranteId.select2({
        placeholder: "Seleccione un Garante",
        multiple: false,
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
                    search_value: term, // search term
                    credito_socio: false,
                    credito_garante_socio_id: $('#Credito_socio_id').val()
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });
    $("#Credito_garante_id").prop("disabled", true);
    $("#Credito_socio_id").change(function () {
        select2vacio('Credito_garante_id');
        $("#Credito_garante_id").prop("disabled", false);
    });
});

function select2vacio(id) {
    $('#' + id).select2("val", "");
}

//function AjaxListaGarantes(lista, lista_actualizar) {
//    $('#s2id_' + lista_actualizar + ' a span').html('');
//    AjaxCargarListas(baseUrl + "crm/persona/ajaxGetGarantes",
//            {socio_id: $("#" + lista).val()}, function (data) {
//        $("#" + lista_actualizar).html(data);
//        $('#s2id_' + lista_actualizar + ' a span').html($("#" + lista_actualizar + " option[id='p']").html());
//        $("#" + lista_actualizar).selectBox("refresh");
//        $('#s2id_' + lista_actualizar).removeClass('select2-container-disabled');
//        $('#' + lista_actualizar).attr({
//            disabled: false,
//        });
//    });
//}

//function AjaxCargarListas(url, data, callBack) {
//    $.ajax({
//        type: 'POST',
//        url: url,
//        data: data,
//        beforeSend: function (xhr) {
//            $('#s2id_Credito_garante_id').addClass('select2-container-disabled');
//            $('#Credito_garante_id').attr({
//                disabled: true,
//            });
//        },
//        success: function (data) {
//            callBack(data);
//        }
//    });
//}