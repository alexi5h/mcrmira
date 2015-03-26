var inputPersonaId, inputPersonaCanton, inputfecha;
$(function() {
    initSelect();
});
//AhorroDeposito_socio_id
function initSelect() {
    inputfecha = $('#AhorroDeposito_fecha_comprobante_entidad');

    inputPersonaId = $("#AhorroDeposito_socio_id");
    //select2
    inputPersonaId.select2({
        placeholder: "Seleccione un Socio",
        multiple: true,
        initSelection: function(element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/persona/ajaxlistSocios",
            type: "get",
            dataType: 'json',
            data: function(term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function(data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });
    //persona canton
    inputPersonaCanton = $("#AhorroDeposito_sucursal_comprobante_id");
    inputPersonaCanton.select2({
        placeholder: "Seleccione un canton",
        multiple: true,
        initSelection: function(element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/sucursal/ajaxlistSucursales",
            type: "get",
            dataType: 'json',
            data: function(term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function(data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });


    inputfecha.datepicker({
        autoclose: true,
        startView: 2,
        minViewMode: 1,
        clearBtn: true,
//        language: "es",
        format: "MM/yyyy",
    });

    inputfecha.datepicker()
            .on('hide', function(e) {
                changeInputFecha()
            });
    $.fn.datepicker.dates['en'] = {
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        today: "Today",
        clear: "Clear"
    };


    //chages
    inputPersonaId.on("change", function(e) {
        updateGrid(getParamsSearch());
    });
    inputPersonaCanton.on("change", function(e) {
        updateGrid(getParamsSearch());

    });


}

function updateGrid($params) {
    $.fn.yiiGridView.update("ahorro-deposito-grid", {
        type: 'GET',
        data: $params
    });
}
function getParamsSearch() {
    return {
        'AhorroDeposito': {
            'socio_id': inputPersonaId.val(),
            'sucursal_comprobante_id': inputPersonaCanton.val(),
            'sucursal_fecha_comprobante_entidad': inputfecha.val(),
        }
    };

}
function changeInputFecha() {
    updateGrid(getParamsSearch());
}

function exporSocio(Formulario) {
    if (!isEmptyGrid("#ahorro-deposito-grid")) //Cuando no este vacio
    {
        $(Formulario).attr('target', "blank");
        $(Formulario).attr('action', baseUrl + 'ahorro/ahorroDeposito/exportarDepositos');
        $(Formulario).submit();
    } else {
        bootbox.alert('No hay datos para exportar');
    }
}

