function AjaxActualizacionInformacion(Formulario)
{
    BloquearBotonesModal(Formulario);
    AjaxGestionModalAhorroExtra(Formulario, function (list) {
        DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxActualizacionInformacion');
    });
}

function AjaxGestionModalAhorroExtra($form, CallBack) {
    var form = $($form);
    var settings = form.data('settings');
    settings.submitting = true;
    AjaxGuardarModalAhorroExtra(true, $form, CallBack);
}

function AjaxGuardarModalAhorroExtra(verificador, Formulario, callBack)
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
                    $.fn.yiiGridView.update('pago-voluntario-grid');
                    $("#mainModal").modal("hide");
                    bootbox.alert(data.message);
                } else {
                    DesBloquearBotonesModal(Formulario, 'Guardar', 'AjaxActualizacionInformacion');
                    bootbox.alert(data.message);
                }
            }
        });
    }
}

function AjaxGuardarTipoExtra() {
    $("#mainModal").modal("hide");
    bootbox.alert('Ahorro ingresado correctamente');
}