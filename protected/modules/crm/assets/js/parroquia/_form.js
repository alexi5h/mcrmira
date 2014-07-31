$(function() {

    $("#Parroquia_provincia_id").change(function() {
        AjaxListaCantones("Parroquia_provincia_id", "Parroquia_canton_id");
    });
});
function AjaxListaCantones(lista, lista_actualizar)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/canton/ajaxGetCantonByProvincia",
            {provincia_id: $("#" + lista).val()}, function(data) {
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