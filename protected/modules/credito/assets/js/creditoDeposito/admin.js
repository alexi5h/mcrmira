var inputPersonaId, inputPersonaCanton;
$(function () {
    inputPersonaId = $("#CreditoDeposito_socio_id");
    inputPersonaId.select2({
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

    //persona canton
    inputPersonaCanton = $("#CreditoDeposito_sucursal_comprobante_id");
    inputPersonaCanton.select2({
        placeholder: "Seleccione un canton",
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
    inputCreditoDepositoAnio = $("#CreditoDepositoAnio");
    inputCreditoDepositoAnio.datepicker({
        minViewMode: 2,
        autoclose: true,
        format: 'yyyy',
        orientation:'top',
        endDate:'today'

    });
    //chages
    inputPersonaId.on("change", function (e) {
        updateGrid(getParamsSearch());
    });
    inputPersonaCanton.on("change", function (e) {
        updateGrid(getParamsSearch());

    });
    inputCreditoDepositoAnio.on("change", function (e) {
        updateGrid(getParamsSearch());
//        anio_seleccionado = parseInt($(this).val());
//        anio_seleccionado_anterior = anio_seleccionado - 1;
        //$("#consolidado-grid_c4").html('Saldo '+ anio_seleccionado_anterior); // tr de saldo
        //$("#consolidado-grid_c17").html('Total '+ anio_seleccionado); // tr de saldo

    });

});

function updateGrid($params) {
    $.fn.yiiGridView.update("credito-deposito-grid", {
        type: 'GET',
        data: $params
    });
}
function getParamsSearch() {
    return {
        'CreditoDeposito': {
            'socio_id': inputPersonaId.val(),
            'sucursal_id': inputPersonaCanton.val(),
            'anio': inputCreditoDepositoAnio.val()
        }
    };

}

function exportCredito(Formulario) {
    if (!isEmptyGrid("#credito-deposito-grid")) //Cuando no este vacio
    {
        $(Formulario).attr('target', "blank");
        $(Formulario).attr('action', baseUrl + 'credito/creditoDeposito/exportarDetalle');
        $(Formulario).submit();
    } else {
        bootbox.alert('No hay datos para exportar');
    }
}