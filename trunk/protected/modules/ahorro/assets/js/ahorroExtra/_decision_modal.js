function AjaxActualizacionInformacion(Formulario)
{
    BloquearBotonesModal(Formulario);
    AjaxGestionModalAhorroExtra(Formulario, function (list) {
//        $.fn.yiiGridView.update('deposito-grid');
//        $.fn.yiiGridView.update('pago-grid');
//        $('#deposito-form').trigger("reset");
//        DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxActualizacionInformacion');
    });
}

function AjaxGestionModalAhorroExtra($form, CallBack) {
//    console.log('entro');
    var form = $($form);
    var settings = form.data('settings');

    settings.submitting = true;
//    $.fn.yiiactiveform.validate(form, function (messages) {
//
//        if ($.isEmptyObject(messages)) {
//            console.log('si');
//            $.each(settings.attributes, function () {
//                $.fn.yiiactiveform.updateInput(this, messages, form);
//            });
//            
//            AjaxGuardarModalAhorroExtra(true, $form, CallBack);
//        }
//        else {
//            console.log(messages);
//            settings = form.data('settings'),
//                    $.each(settings.attributes, function () {
//                        $.fn.yiiactiveform.updateInput(this, messages, form);
//                    });
////            DesBloquearBotonesModal($form, 'Guardar', 'AjaxActualizacionInformacion');
//        }
//    });
    AjaxGuardarModalAhorroExtra(true, $form, CallBack);
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
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if (data.success) {
                    console.log('done');
                    $("#mainModal").modal("hide");
                    bootbox.alert(data.message);
//                    if (!data.enableButtonSave) {
//                        $('#buttondeposito').remove();
//                    }
//                    if(data.cantidadExtra!=0){
//                        $("#mainBigModal").modal("hide");
//                    }
//                    console.log(data.cantidadExtra);
//                    callBack(listaActualizar, data);

                } else {
                    DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxActualizacionInformacion');
                    bootbox.alert(data.message);
                }
            }
        });
    }

}