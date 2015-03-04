$(
        function () {

        }
);

function AjaxAtualizacionInformacion(Formulario)
{
    BloquearBotonesModal(Formulario);
    AjaxGestionModal(Formulario, function (list, data) {
$.fn.yiiGridView.update('ahorro-grid');
    });
}
