/**
 * @param {type} Formulario
 * guarda los _form_modal por ajax para contacto, tarea, oportunidad, evento y cobranza
 */

function AjaxActualizacionInformacion(Formulario)
{
    BloquearBotonesModal(Formulario);
    AjaxGestionModalAhorroExtra(Formulario, function(list) {
        $.fn.yiiGridView.update('deposito-grid');
        $.fn.yiiGridView.update('pago-grid');
        $('#deposito-form').trigger("reset");
        DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxActualizacionInformacion');
//        bootbox.confirm('jjj', function(param) {
//            console.log(param);
//        });
    });
}

function AjaxGestionModalAhorroExtra($form, CallBack) {
//    console.log('entro');
    var form = $($form);
    var settings = form.data('settings');
    settings.submitting = true;
    $.fn.yiiactiveform.validate(form, function(messages) {

        $.each(messages, function() {
//            console.log(this);
        });
        if ($.isEmptyObject(messages)) {
            $.each(settings.attributes, function() {
                $.fn.yiiactiveform.updateInput(this, messages, form);
            });
            AjaxGuardarModalAhorroExtra(true, $form, CallBack);
        }
        else {
            settings = form.data('settings'),
                    $.each(settings.attributes, function() {
                        $.fn.yiiactiveform.updateInput(this, messages, form);
                    });
            DesBloquearBotonesModal($form, 'Guardar', 'AjaxActualizacionInformacion');
        }
    });
}
function AjaxGuardarModalAhorroExtra(verificador, Formulario, callBack)
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
            beforeSend: function(xhr) {
            },
            success: function(data) {
                if (data.success) {
//                    $("#mainBigModal").modal("hide");
                    if (!data.enableButtonSave) {
                        $('#buttondeposito').remove();
                    }
                    if(data.cantidadExtra!=0){
                        $("#mainBigModal").modal("hide");
                    }
                    console.log(data.cantidadExtra);
                    callBack(listaActualizar, data);

                } else {
                    DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxActualizacionInformacion');
                    bootbox.alert(data.message);
                }
            }
        });
    }

}