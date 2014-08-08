/**
 * @param {type} Formulario
 * guarda los _form_modal por ajax para contacto, tarea, oportunidad, evento y cobranza
 */
function AjaxAtualizacionInformacion(Formulario)
{
    BloquearBotonesModal(Formulario);
    AjaxGestionModal(Formulario, function(list) {
        
        
    });
}

function activarVistas(e) { 
    console.log(e);
    selectedValues = {};
    $('input[name="allClient_toggle"]').prop("checked", e);
    if (e) {//nuevo deposito
        tab = 'nuevo-deposito';
        $('#depositos-pago').fadeOut(001); //ocultar
        $('#nuevo-deposito').fadeIn('slow'); //mostrar

    } else {//depositos        
        tab = 'depositos-pago';
        $('#depositos-pago').removeClass('hidden'); //mostrar deopositos
        $('#nuevo-deposito').fadeOut(001); //ocultar 
        $('#depositos-pago').fadeIn('slow'); //mostrar

    }
}