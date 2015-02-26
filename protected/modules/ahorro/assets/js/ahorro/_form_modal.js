function save(form_id) {
    ajaxValidarFormulario({
        formId: form_id,
        beforeCall: function () {
            BloquearBotonesModal(form_id);
        },
        successCall: function (data) {
            $("#mainModal").modal("hide");
            if (data.success) {
                $.fn.yiiGridView.update("pago-grid");
            } else {
                bootbox.alert(data.message);
            }

        },
        errorCall: function (data) {
            DesBloquearBotonesModal(form_id, ' Crear', 'save');
        }
    });
}
