$(function () {
    $("#Credito_socio_id").change(function () {
        AjaxListaGarantes("Credito_socio_id", "Credito_garante_id");
    });
});

function AjaxListaGarantes(lista, lista_actualizar) {
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/persona/ajaxGetGarantes",
            {socio_id: $("#" + lista).val()}, function (data) {
        $("#" + lista_actualizar).html(data);
        $('#s2id_' + lista_actualizar + ' a span').html($("#" + lista_actualizar + " option[id='p']").html());
        $("#" + lista_actualizar).selectBox("refresh");
        $('#s2id_' + lista_actualizar).removeClass('select2-container-disabled');
        $('#' + lista_actualizar).attr({
            disabled: false,
        });
    });
}

function AjaxCargarListas(url, data, callBack) {
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        beforeSend: function (xhr) {
            $('#s2id_Credito_garante_id').addClass('select2-container-disabled');
            $('#Credito_garante_id').attr({
                disabled: true,
            });
        },
        success: function (data) {
            callBack(data);
        }
    });
}