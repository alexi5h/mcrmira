function save(form_id) {
    ajaxValidarFormulario({
        formId: form_id,
        beforeCall: function () {
            BloquearBotonesModal(form_id);
        },
        successCall: function (data) {
            
        },
        errorCall: function (data) {
            DesBloquearBotonesModal(form_id, ' Crear', 'save');
        }
    });
}
