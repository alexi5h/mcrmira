$(function () {

    $("#Direccion1_provincia_id").change(function () {
        AjaxListaCantones("Direccion1_provincia_id", "Direccion1_canton_id");
    });
    $("#Direccion1_canton_id").change(function () {
        AjaxListaParroquias("Direccion1_canton_id", "Direccion1_parroquia_id");
    });
    $("#Direccion1_parroquia_id").change(function () {
        AjaxListaBarrios("Direccion1_parroquia_id", "Direccion1_barrio_id");
    });
    $("#Direccion2_provincia_id").change(function () {
        AjaxListaCantones("Direccion2_provincia_id", "Direccion2_canton_id");
    });
    $("#Direccion2_canton_id").change(function () {
        AjaxListaParroquias("Direccion2_canton_id", "Direccion2_parroquia_id");
    });
    $("#Direccion2_parroquia_id").change(function () {
        AjaxListaBarrios("Direccion2_parroquia_id", "Direccion2_barrio_id");
    });

//    $('#Persona_tipo_identificacion_0').on('click', function () {
//        $('#Persona_cedula').attr({
//            disabled: false,
//        });
//        $('#Persona_cedula').mask('0000000000');
//    });

//    $('#Persona_tipo_identificacion_1').on('click', function () {
//        $('#Persona_cedula').attr({
//            disabled: false,
//        });
//        $('#Persona_cedula').unmask();
//    });
});
function AjaxListaCantones(lista, lista_actualizar)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/canton/ajaxGetCantonByProvincia",
            {provincia_id: $("#" + lista).val()}, function (data) {
        $("#" + lista_actualizar).html(data);
        $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + " option[id='p']").html());
        $('#s2id_' + lista_actualizar + ' a span.select2-arrow').html('<b></b>');
        $("#" + lista_actualizar).selectBox("refresh");

    });
}
function AjaxListaParroquias(lista, lista_actualizar)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/parroquia/ajaxGetParroquiaByCanton",
            {canton_id: $("#" + lista).val()}, function (data) {
        $("#" + lista_actualizar).html(data);
        $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + " option[id='p']").html());
        $('#s2id_' + lista_actualizar + ' a span.select2-arrow').html('<b></b>');
        $("#" + lista_actualizar).selectBox("refresh");

    });
}
function AjaxListaBarrios(lista, lista_actualizar)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/barrio/ajaxGetBarrioByParroquia",
            {parroquia_id: $("#" + lista).val()}, function (data) {
        $("#" + lista_actualizar).html(data);
        $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + " option[id='p']").html());
        $('#s2id_' + lista_actualizar + ' a span.select2-arrow').html('<b></b>');
        $("#" + lista_actualizar).selectBox("refresh");

    });
}
function AjaxCargarListas(url, data, callBack)
{
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (data) {
            callBack(data);
        }
    });
}

function guardarActividadEconomicaPopouver(formulario, popoup)
{
    $.ajax({
        type: "POST",
        url: baseUrl + "crm/actividadEconomica/create/popoup/1",
        data: $(formulario).serialize(),
        dataType: "json",
        beforeSend: function () {

//            showModalLoading(tipo);
        },
        success: function (data) {
            lista_actualizar = "Persona_actividad_economica_id";

            if (data.success) {
                idSelected = data.seleccion;
                AjaxCargarListas(baseUrl + "crm/actividadEconomica/ajaxGetActividadesEconomicas",
                        {nuevo: idSelected}, function (data) {
                    $("#" + lista_actualizar).html(data);
                    $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + " option[id='p']").html());
                    $('#s2id_' + lista_actualizar + ' a span.select2-arrow').html('<b></b>');
                    $("#" + lista_actualizar).selectBox("refresh");
                    $('#' + lista_actualizar + ' > option[value="' + idSelected + '"]').attr('selected', 'selected');
                    $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + ' > option[value="' + idSelected + '"]').html());

                });

                $(popoup).popover("hide");
            }

        }
    });


}

