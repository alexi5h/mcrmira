var inputCreditoFechaRango, inputNumeroCheque, inputSocioId, inputSucursalId;
$(function () {
    initSelect();
});
function initSelect() {
    //filtro de fechas
    inputCreditoFechaRango= $('#Credito_fecha_rango');
    inputCreditoFechaRango.daterangepicker(
        {
            format: 'MM/YYYY',
            ranges: {
                'Año Actual': [moment().month(0), moment().month("December")],
                'Año Anterior': [moment().subtract('years', (+1)).month(0), moment().subtract('years', (+1)).month(11)]
            },
            startDate: moment().subtract(29, 'days'),
            locale: {
                applyLabel: 'Aplicar',
                cancelLabel: 'Limpiar',
                fromLabel: 'DESDE',
                toLabel: 'HASTA',
                customRangeLabel: 'Rango Personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            }

        }
    ).on('cancel.daterangepicker', function (ev, picker) {
            $('#Credito_fecha_rango').val(null);
            updateGrid(getParamsSearch());

        })
        .on('apply.daterangepicker', function (ev, picker) {
            $('#Credito_fecha_rango').val(picker.startDate.format('YYYY-MM-DD')+' / '+picker.endDate.format('YYYY-MM-DD'));
            updateGrid(getParamsSearch());
        });
    ;
    inputCreditoFechaRango.attr({
        placeholder: 'Seleccione un Rango'
    });
    
    inputNumeroCheque = $("#Credito_numero_cheque");
    //select2
    inputNumeroCheque.select2({
        placeholder: "Seleccione un Número de Cheque",
        multiple: true,
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "credito/credito/ajaxlistCreditos",
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                return {
                    socio_ids: inputSocioId.val(),
                    search_value: term // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });

    inputSocioId = $("#Credito_socio_id");
    //select2
    inputSocioId.select2({
        placeholder: "Seleccione un Socio",
        multiple: true,
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/persona/ajaxlistSocios",
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });

    inputSucursalId = $("#Credito_sucursal_id");
    //select2
    inputSucursalId.select2({
        placeholder: "Seleccione un Cantón",
        multiple: true,
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: baseUrl + "crm/sucursal/ajaxlistSucursales",
            type: "get",
            dataType: 'json',
            data: function (term, page) {
                return {
                    search_value: term // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        }
    });

    inputNumeroCheque.on("change", function (e) {
        updateGrid(getParamsSearch());
    });
    inputSocioId.on("change", function (e) {
        select2vacio('Credito_numero_cheque');
        updateGrid(getParamsSearch());
    });
    inputSucursalId.on("change", function (e) {
        updateGrid(getParamsSearch());
    });
}
function updateGrid($params) {
    $.fn.yiiGridView.update("credito-grid", {
        type: 'GET',
        data: $params
    });
}
function getParamsSearch() {
    return {
        'Credito': {
            'numero_cheque': inputNumeroCheque.val(),
            'socio_id': inputSocioId.val(),
            'sucursal_id': inputSucursalId.val(),
            'fecha_rango': inputCreditoFechaRango.val()
        }
    };
}

function select2vacio(id) {
    $('#' + id).select2("val", "");
}

function exportCredito(Formulario) {
    if (!isEmptyGrid("#credito-grid")) {
        $(Formulario).attr('target', "blank");
        $(Formulario).attr('action', baseUrl + 'credito/credito/exportarCredito');
        $(Formulario).submit();
    } else {
        bootbox.alert('No hay datos para exportar');
    }
}