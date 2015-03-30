$(
        function () {

        }
);
function AjaxAtualizacionInformacion(Formulario)
{
    BloquearBotonesModal(Formulario);
    AjaxGestionModal(Formulario, function (list, data) {
       if (data.success) {
            $.fn.yiiGridView.update('ahorro-deposito-grid');
            $.fn.yiiGridView.update('deposito-grid-grid');
            if ($('#wrapper_grid_deposito').attr('hidden')) {
                $('#wrapper_grid_deposito').removeAttr('hidden');
                $('#add-Deposito').removeClass('empty-portlet');
                $('#add-Deposito').html('<i class="icon-plus-sign"></i> Depositar');
            }
        } else {
            bootbox.alert(data.message);
        }
     
    });
}


//function save(form_id) {
//    ajaxValidarFormulario({
//        formId: form_id,
//        beforeCall: function () {
//            BloquearBotonesModal(form_id);
//        },
//        successCall: function (data) {
//            $("#mainModal").modal("hide");
//            if (data.success) {
//                $.fn.yiiGridView.update('ahorro-deposito-grid');
//                $.fn.yiiGridView.update('deposito-grid-grid');
//                if ($('#wrapper_grid_deposito').attr('hidden')) {
//                    $('#wrapper_grid_deposito').removeAttr('hidden');
//                    $('#add-Deposito').removeClass('empty-portlet');                    
//                    $('#add-Deposito').html('<i class="icon-plus-sign"></i> Depositar');
//                }
//            } else {
//                bootbox.alert(data.message);
//            }
//
//        },
//        errorCall: function (data) {
//            DesBloquearBotonesModal(form_id, ' Crear', 'save');
//        }
//    });
//}