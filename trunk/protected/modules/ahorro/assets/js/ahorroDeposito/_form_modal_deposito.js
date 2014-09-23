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
//    viewModal('ahorro/ahorroExtra/create/ahorro_id/12/cantidad_extra/10');
    BloquearBotonesModal(Formulario);
    AjaxGestionModalDeposito(Formulario, function (list) {
        $.fn.yiiGridView.update('deposito-grid');
        $.fn.yiiGridView.update('pago-grid');
        $('#deposito-form').trigger("reset");
        DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxAtualizacionInformacion');
//        bootbox.confirm('jjj', function(param) {
//            console.log(param);
//        });
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
//    console.log('entro dos');
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
                        viewModal('ahorro/ahorroExtra/create/ahorro_id/' + data.ahorro_id + '/cantidad_extra/' + data.cantidadExtra, function () {
                            maskAttributes();
                        });
                    }
                    console.log(data.cantidadExtra);
                    callBack(listaActualizar, data);

                } else {
                    DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxAtualizacionInformacion');
                    bootbox.alert(data.message);
                }
            }
        });
    }

}