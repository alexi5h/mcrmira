var inputAhorroSocioId, inputSucursalId,inputAhorroFechaRango;
$(function () {
    init();
});
function showModalLoadingWidth() {
    var html = "";
    html += "<div class='modal-header'><h4><i class='icon-refresh'></i> Cargando</h4></div>";
    html += "<div class='loading'><img src='" + themeUrl + "images/truulo-loading.gif' /></div>";
    $("#mainModal").html(html);
    $("#mainModal").modal("show");
}

function showModalDataWidth(html) {
    $("#mainBigModal").html(html);
    $("#mainBigModal").modal("show");
    $('select.fix').selectBox();
}

/**
 *
 * @param {cadena} url
 * @returns {undefined}
 */
function viewModalWidth(url, CallBack) {
    $.ajax({
        type: "POST",
        url: baseUrl + url,
        beforeSend: function () {
            showModalLoadingWidth();
        },
        success: function (data) {
            $("#mainModal").modal("hide");

            showModalDataWidth(data);
            CallBack();
            actualizarGrid();

        }
    });
}
function actualizarGrid() {
    $(".modal-header>a.close").click(function () {
        $.fn.yiiGridView.update('ahorro-grid');
    });
    $(".modal-footer>a.btn").click(function () {
        $.fn.yiiGridView.update('ahorro-grid');
    });
    $("#buttondeposito>a.btn-success").click(function () {
        $.fn.yiiGridView.update('ahorro-grid');
    });
}

function init() {
    inputAhorroSocioId = $("#Ahorro_socio_id");
    //select2
    inputAhorroSocioId.select2({
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

    inputSucursalId = $("#Ahorro_sucursal_id");
    //select2
    inputSucursalId.select2({
        placeholder: "Seleccione una Sucursal",
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
    //filtro de fechas
    inputAhorroFechaRango= $('#Ahorro_fecha_rango');
    inputAhorroFechaRango.daterangepicker(
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
            $('#Ahorro_fecha_rango').val(null);
            updateGrid(getParamsSearch());

        })
        .on('apply.daterangepicker', function (ev, picker) {
            $('#Ahorro_fecha_rango').val(picker.startDate.format('YYYY-MM-DD')+' / '+picker.endDate.format('YYYY-MM-DD'));
            updateGrid(getParamsSearch());
        });
    ;
    inputAhorroFechaRango.attr({
        placeholder: 'Seleccione un Rango'
    });
    //
    inputAhorroSocioId.on("change", function (e) {
        updateGrid(getParamsSearch());

    });
    inputSucursalId.on("change", function (e) {
        updateGrid(getParamsSearch());

    });
}
function updateGrid($params) {
    $.fn.yiiGridView.update("ahorro-grid", {
        type: 'GET',
        data: $params
    });
}
function getParamsSearch() {
    return {
        'Ahorro': {
            'socio_id': inputAhorroSocioId.val(),
            'sucursal_id': inputSucursalId.val(),
            'fecha_rango': inputAhorroFechaRango.val()
        }
    };

}

function exporSocio(Formulario) {
    if (!isEmptyGrid("#persona-grid")) //Cuando no este vacio
    {
        $(Formulario).attr('target', "blank");
        $(Formulario).attr('action', baseUrl + 'crm/persona/exportarSocio');
        $(Formulario).submit();
    } else {
        bootbox.alert('No hay datos para exportar');
    }
}