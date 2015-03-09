var inputPersonaId, inputPersonaCanton, inputPersonaSexo, inputPersonaEstadoCivil, inputPersonaDiscapacidad, inputPersonaMadreSoltera;
$(function () {
    initSelect();
});
function initSelect() {
    inputPersonaId = $("#Persona_id");
    //select2
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
    inputPersonaCanton = $("#Persona_sucursal_id");
    inputPersonaCanton.select2({
        placeholder: "Seleccione una sucursal",
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
    inputPersonaSexo = $("#Persona_sexo");
    inputPersonaSexo.select2({
        placeholder: "Seleccione un género",
        multiple: false,
        data: [{id: null, text: 'Ambos'}, {id: 'F', text: 'Mujeres'}, {id: 'M', text: 'Hombres'}],
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        }
    });
    inputPersonaEstadoCivil = $("#Persona_estado_civil");
    inputPersonaEstadoCivil.select2({
        placeholder: "Seleccione un estado civil",
        multiple: false,
        data: [{id: null, text: 'Todos'}, {id: 'SOLTERO', text: 'Soltero'}, {
            id: 'CASADO',
            text: 'Casado'
        }, {id: 'DIVORCIADO', text: 'Divorciado'}, {id: 'VIUDO', text: 'Viudo'}],
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        }
    });
    inputPersonaDiscapacidad = $("#Persona_discapacidad");
    inputPersonaDiscapacidad.select2({
        placeholder: "Seleccione un una",
        multiple: false,
        data: [{id: null, text: 'Todos'}, {id: 'SI', text: 'Si'}, {id: 'NO', text: 'No'}],
        initSelection: function (element, callback) {
            if ($(element).val()) {
                var data = {id: element.val(), text: $(element).attr('selected-text')};
                callback(data);
            }
        }
    });
    inputPersonaMadreSoltera = $('#Persona_madre_soltera');
    inputPersonaMadreSoltera.bootstrapToggle({
        on: 'SI',
        off: 'NO',
        onstyle: 'primary',
        offstyle: 'warning'
    });
    inputPersonaId.on("change", function (e) {
        updateGrid(getParamsSearch());
    });
    inputPersonaCanton.on("change", function (e) {
        updateGrid(getParamsSearch());

    });
    inputPersonaDiscapacidad.on("change", function (e) {
        updateGrid(getParamsSearch());

    });
    inputPersonaEstadoCivil.on("change", function (e) {
        updateGrid(getParamsSearch());

    });
    inputPersonaMadreSoltera.on("change", function (e) {
        updateGrid(getParamsSearch());

    });
    inputPersonaSexo.on("change", function (e) {
        updateGrid(getParamsSearch());

    });
}
function updateGrid($params) {
    $.fn.yiiGridView.update("persona-grid", {
        type: 'GET',
        data: $params
    });
}
function getParamsSearch() {
    return {
        'Persona': {
            'id': inputPersonaId.val(),
            'sucursal_ids': inputPersonaCanton.val(),
            'discapacidad': inputPersonaDiscapacidad.val(),
            'estado_civil': inputPersonaEstadoCivil.val(),
            'sexo': inputPersonaSexo.val(),
            'madreSoltera': inputPersonaMadreSoltera.prop('checked')
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