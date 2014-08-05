$(function() {
    resizeKanban();
    $(window).resize(function() {
        resizeKanban();
    });
    $('.icon-reorder').click(function() {
        resizeKanban();
    });
    ParametrosArrastrables();
    

});
function resizeKanban() {
    $('.kanban-container').css({'height': (($(window).height()) - 240) + 'px'});
    $('.kanban-container').niceScroll({
        styler: "fb", cursorcolor: "#008AC5", cursorwidth: '8', cursorborderradius: '0px', background: '#DDDDDD', cursorborder: '', autohidemode: false
    });

    $('.kanban-stage').each(function() {
        $(this).find('.kanban-body').css({'height': 'auto'});

        if ($(this).height() > $('.kanban-container').height()) {
            $(this).find('.kanban-body').css({'height': ($('.kanban-container').height() - 60) + 'px'});
        }

        $(this).find('.kanban-body').niceScroll({
            styler: "fb", cursorcolor: "#555555", cursorwidth: '4', cursorborderradius: '0px', background: '#DDDDDD', cursorborder: '', autohidemode: false
        });
    });
}
/**
 * @author  Alex Yepez 
 * agrega la accion sortable a los oportunidades 
 */
function ParametrosArrastrables()
{
    $(".kanban-body").sortable({
        placeholder: "ui-state-highlight",
        connectWith: "ul",
        receive: function(event, ui) {
            resizeKanban();
            var url = baseUrl + '/incidencias/incidencia/ajaxUpdateEstado';
            enviarDatos(ui.item.attr('data-id'), $(this).attr("cont-id"), url);
        }
    });
}

/**
 * Envia datos a la accion ajaxUpdateEstado, para actualizar en estado_id de la Incidencia
 * @autor Armando Maldonado
 * @param {type} id_data
 * @param {type} id_estado
 * @param {type} url
 * @returns {undefined}
 */
function enviarDatos(id_data, id_estado, url)
{
    $.ajax({
        type: 'GET',
        url: url + '/id_data/' + id_data + '/id_estado/' + id_estado,
    });
}
/**
 * @author Alex Yepez <ayepez@tradesystem.com.ec>
 * @param {type} lista
 * Actualiza el panel kanban
 */
function ActualizarInformacion(lista)
{
    var url = baseUrl + "incidencias/incidencia/Kanban";
    //actualizacion de Kanban
    AjaxUpdateElement(url, ".kanban-container", function() {
        resizeKanban();
        ParametrosArrastrables();
    });
}
/**
 * @author Alex Yepez <ayepez@tradesystem.com.ec>
 * @param {type} Formulario
 * guarda los _form_modal por ajax para contacto, tarea, oportunidad, evento y cobranza
 */
function AjaxAtualizacionInformacion(Formulario)
{
    BloquearBotonesModal(Formulario);
    AjaxGestionModal(Formulario,function(list){
        ActualizarInformacion(list);
    });
}

