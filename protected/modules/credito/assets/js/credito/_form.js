$(function () {
//    $('#Credito_cantidad_total').val('abcde');
    $("#Credito_socio_id").change(function () {
        AjaxListaGarantes("Credito_socio_id", "Credito_garante_id");
    });
});

function AjaxListaGarantes(lista, lista_actualizar)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/persona/ajaxGetGarantes",
            {socio_id: $("#" + lista).val()}, function(data) {
        $("#" + lista_actualizar).html(data);
        $('#s2id_' + lista_actualizar + ' a span').html($("#" + lista_actualizar + " option[id='p']").html());
        $("#" + lista_actualizar).selectBox("refresh");

    });
}

function AjaxCargarListas(url, data, callBack)
{
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(data) {
            callBack(data);
        }
    });
}