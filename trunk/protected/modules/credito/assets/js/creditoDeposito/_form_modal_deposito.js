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
function AjaxActualizacionInformacion(Formulario)
{
//    viewModal('ahorro/ahorro/create/ahorro_id/39/ahorro_extra_id/1', function () {
//        maskAttributes();
//    });
    BloquearBotonesModal(Formulario);
    AjaxGestionModalDeposito(Formulario, function (list) {
        $.fn.yiiGridView.update('credito-amortizacion-grid');
        $.fn.yiiGridView.update('credito-grid');
        $('#credito-deposito-form').trigger("reset");
        DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxActualizacionInformacion');
//        bootbox.confirm('jjj', function(param) {
//            console.log(param);
//        });
    });
}

function AjaxGestionModalDeposito($form, CallBack) {
//    console.log('entro');
    var form = $($form);
    var settings = form.data('settings');
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
            DesBloquearBotonesModal($form, 'Guardar', 'AjaxActualizacionInformacion');
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
                    $('#centrado > h4').html('$'+data.saldo_contra+' por pagar');
//                    if (!data.enableButtonSave) {
//                        $('#buttondeposito').remove();
//                    }
                    if (data.cantidadExtra != 0) {
                        $("#mainBigModal").modal("hide");
                        bootbox.alert(data.message);
//                        viewModal('ahorro/ahorro/crearVoluntario/socio_id/' + data.socio_id + '/cantidad/' + data.cantidad_extra, function () {});
                    }else{
                        if(data.pagado){
                            $("#mainBigModal").modal("hide");
                        }
                    }
//                    console.log(data.cantidadExtra);
                    callBack(listaActualizar, data);

                } else {
                    DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxActualizacionInformacion');
                    bootbox.alert(data.message);
                }
            }
        });
    }

}