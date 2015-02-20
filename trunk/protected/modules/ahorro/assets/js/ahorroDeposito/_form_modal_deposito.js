//$(function() {
//    $("#AhorroDeposito_cantidad").on('keyup', function() {
//        var value = $(this).val();
//        $("#cantidad-extra").val(value);
//    }).keyup();
//});

/**
 * @param {type} Formulario
 * guarda los _form_modal por ajax para contacto, tarea, oportunidad, evento y cobranza
 */
function AjaxAtualizacionInformacion(Formulario)
{
//    viewModal('ahorro/ahorro/create/ahorro_id/39/ahorro_extra_id/1', function () {
//        maskAttributes();
//    });
    BloquearBotonesModal(Formulario);
    AjaxGestionModalDeposito(Formulario, function (list) {
        $.fn.yiiGridView.update('deposito-grid');
        $.fn.yiiGridView.update('pago-grid');
        $.fn.yiiGridView.update('deposito-grid-grid');
        $('#deposito-form').trigger("reset");
        DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxAtualizacionInformacion');
    });
}

function AjaxGestionModalDeposito($form, CallBack) {
//    console.log('entro');
    var form = $($form);
    var settings = form.data('settings');
//    console.log(settings);
    settings.submitting = true;
    $.fn.yiiactiveform.validate(form, function (messages) {
        if ($.isEmptyObject(messages)) {
            $.each(settings.attributes, function () {
                $.fn.yiiactiveform.updateInput(this, messages, form);
            });
            AjaxGuardarModalDeposito(true, $form, CallBack);
        }
        else {
            settings = form.data('settings'),
                    $.each(settings.attributes, function () {
                        $.fn.yiiactiveform.updateInput(this, messages, form);
                    });
            DesBloquearBotonesModal($form, 'Guardar', 'AjaxAtualizacionInformacion');
        }
    });
}
function AjaxGuardarModalDeposito(verificador, Formulario, callBack)
{
    if (verificador)
    {
        var listaActualizar = Formulario.split('-');
        listaActualizar = listaActualizar[0] + '-grid';
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: $(Formulario).attr('action'),
            data: $(Formulario).serialize(),
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if (data.success) {
                    if (!data.enableButtonSave) {
                        $('#buttondeposito').remove();
                    }
                    if (data.cantidadExtra != 0) {
                        $("#mainBigModal").modal("hide");
                        viewModal('ahorro/ahorro/create/ahorro_id/' + data.ahorro_id + '/ahorro_extra_id/' + data.ahorro_extra_id, function () {
                        });
                    }
//                    else {
//                        $("#mainBigModal").modal("hide");
//                    }
//                    console.log(data.cantidadExtra);
                    callBack(listaActualizar, data);

                    restaurarCampos();
                } else {
                    DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxAtualizacionInformacion');
                    bootbox.alert(data.message);
                }
            }
        });
    }

}
function restaurarCampos() {
    $("#AhorroDeposito_cantidad").val("");
    var select = $("#AhorroDeposito_entidad_bancaria_id");
    select.val($('option:first', select).val());
    $("#AhorroDeposito_cod_comprobante_entidad").val("");
    $("#AhorroDeposito_fecha_comprobante_entidad").val("");
    $("#AhorroDeposito_cod_comprobante_su").val("");

}