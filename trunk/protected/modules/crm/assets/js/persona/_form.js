provinciaNegocio = null;
cantonNegocio = null;
provinciaDomicilio = null;
cantonDomicilio = null;
$(function() {

    $("#Direccion1_provincia_id").change(function() {
        AjaxListaCantones("Direccion1_provincia_id", "Direccion1_canton_id");
        provinciaDomicilio = $(this).val();

    });
    $("#Direccion1_canton_id").change(function() {
        AjaxListaParroquias("Direccion1_canton_id", "Direccion1_parroquia_id");
        cantonDomicilio = $(this).val();

    });
    $("#Direccion1_parroquia_id").change(function() {
        AjaxListaBarrios("Direccion1_parroquia_id", "Direccion1_barrio_id");
    });
    $("#Direccion2_provincia_id").change(function() {
        AjaxListaCantones("Direccion2_provincia_id", "Direccion2_canton_id");
        provinciaNegocio = $(this).val();

    });
    $("#Direccion2_canton_id").change(function() {
        AjaxListaParroquias("Direccion2_canton_id", "Direccion2_parroquia_id");
        cantonNegocio = $(this).val();

    });
    $("#Direccion2_parroquia_id").change(function() {
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

    $('#newParroquiaNegocio').on('shown.bs.popover', function(data) {
        cambiarCamposPopouver('Parroquia_provincia_id', provinciaNegocio);

        AjaxListaCantones("Parroquia_provincia_id", "Parroquia_canton_id", function() {
            cambiarCamposPopouver('Parroquia_canton_id', cantonNegocio);
        });

        $("#Parroquia_provincia_id").change(function() {
            window.console.log($("#Parroquia_provincia_id"));
            AjaxListaCantones("Parroquia_provincia_id", "Parroquia_canton_id");
        });
    });
    $('#newParroquiaDomicilio').on('shown.bs.popover', function(data) {
        cambiarCamposPopouver('Parroquia_provincia_id', provinciaDomicilio);

        AjaxListaCantones("Parroquia_provincia_id", "Parroquia_canton_id", function() {
            cambiarCamposPopouver('Parroquia_canton_id', cantonDomicilio);
        });

        $("#Parroquia_provincia_id").change(function() {
            window.console.log($("#Parroquia_provincia_id"));
            AjaxListaCantones("Parroquia_provincia_id", "Parroquia_canton_id");
        });
    });

});
function AjaxListaCantones(lista, lista_actualizar, callBack)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/canton/ajaxGetCantonByProvincia",
            {provincia_id: $("#" + lista).val()}, function(data) {
        $("#" + lista_actualizar).html(data);
        $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + " option[id='p']").html());
        $('#s2id_' + lista_actualizar + ' a span.select2-arrow').html('<b></b>');
        $("#" + lista_actualizar).selectBox("refresh");
//        window.console.log(callBack == undefined);
        if (callBack != undefined) {
            callBack();
        }
    });
}
function AjaxListaParroquias(lista, lista_actualizar)
{
    $('#s2id_' + lista_actualizar + ' a span').html('');
    AjaxCargarListas(baseUrl + "crm/parroquia/ajaxGetParroquiaByCanton",
            {canton_id: $("#" + lista).val()}, function(data) {
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
            {parroquia_id: $("#" + lista).val()}, function(data) {
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
        success: function(data) {
            callBack(data);
        }
    });
}
function cambiarCamposPopouver(lista_actualizar, idSelected) {
    $('#' + lista_actualizar + ' > option[value="' + idSelected + '"]').attr('selected', 'selected');
//    $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + ' > option[value="' + idSelected + '"]').html());
}

function guardarActividadEconomicaPopouver($form, popoup, lista_actualizar)
{
//    window.console.log($form);
//    alert('save');
    ajaxValidarFormulario({
        formId: $form,
        beforeCall: function() {

        },
        errorCall: function() {

        },
        successCall: function(data) {
//            lista_actualizar = "Persona_actividad_economica_id";
            if (data.success) {
                idSelected = data.seleccion;
                AjaxCargarListas(baseUrl + "crm/actividadEconomica/ajaxGetActividadesEconomicas",
                        {nuevo: idSelected}, function(data) {
                    $("#" + lista_actualizar).html(data);
                    $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + " option[id='p']").html());
                    $('#s2id_' + lista_actualizar + ' a span.select2-arrow').html('<b></b>');
                    $("#" + lista_actualizar).selectBox("refresh");
                    $('#' + lista_actualizar + ' > option[value="' + idSelected + '"]').attr('selected', 'selected');
                    $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + ' > option[value="' + idSelected + '"]').html());

                });
                $(popoup).popover("hide");

            }
//

        }
    });



}
function guardarParroquiaPopouver($form, popoup, lista_actualizar, tipoDireccion)
{
//    window.console.log($form);
//    alert('save');
    ajaxValidarFormulario({
        formId: $form,
        beforeCall: function() {

        },
        errorCall: function() {

        },
        successCall: function(data) {
//            lista_actualizar = "Persona_actividad_economica_id";
            idCanton = data.seleccion.canton_id;
            idProvincia = data.provincia;

            if (data.success) {
                idSelected = data.seleccion.id;
                AjaxCargarListas(baseUrl + "crm/parroquia/ajaxGetParroquiaByCanton",
                        {canton_id: data.seleccion.canton_id}, function(data) {
                    $("#" + lista_actualizar).html(data);
                    $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + " option[id='p']").html());
                    $('#s2id_' + lista_actualizar + ' a span.select2-arrow').html('<b></b>');
                    $("#" + lista_actualizar).selectBox("refresh");

                    $('#Direccion' + tipoDireccion + '_provincia_id > option[value="' + idProvincia + '"]').attr('selected', 'selected');
                    $('#s2id_Direccion' + tipoDireccion + '_provincia_id  a span.select2-chosen').html($('#Direccion' + tipoDireccion + '_provincia_id  > option[value="' + idProvincia + '"]').html());

                    AjaxListaCantones('Direccion' + tipoDireccion + '_provincia_id', 'Direccion' + tipoDireccion + '_canton_id', function() {
                        $('#Direccion' + tipoDireccion + '_canton_id > option[value="' + idCanton + '"]').attr('selected', 'selected');
                        $('#s2id_Direccion' + tipoDireccion + '_canton_id a span.select2-chosen').html($('#Direccion' + tipoDireccion + '_canton_id > option[value="' + idCanton + '"]').html());
                    });

                    $('#' + lista_actualizar + ' > option[value="' + idSelected + '"]').attr('selected', 'selected');
                    $('#s2id_' + lista_actualizar + ' a span.select2-chosen').html($("#" + lista_actualizar + ' > option[value="' + idSelected + '"]').html());

                });
                $(popoup).popover("hide");

            }
//

        }
    });



}










