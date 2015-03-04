$(
        function () {

        }
);

function AjaxAtualizacionInformacion(Formulario)
{
    BloquearBotonesModal(Formulario);
    AjaxGestionModal(Formulario, function (list, data) {

//        ActualizarInformacion(list);
//        ActualizarInformacion('#clt-deuda-grid');
    });
}
