var inputAhorroDepositoSocioId;
$(function() {
    init();
});
function init() {
    inputAhorroDepositoSocioId = $("#AhorroDeposito_socio_id");
    //select2
    inputAhorroDepositoSocioId.select2({
        placeholder: "Seleccione un Socio",
        multiple: false,
        initSelection: function(element, callback) {
            if ($(element).val()) {
                $.ajax(baseUrl + "crm/persona/ajaxInfo/id/" + element.val(), {
                    dataType: "json"
                }).done(function(data) {
                    var data = {id: element.val(), text: data.Persona.apellido_paterno + " " + data.Persona.apellido_materno + " " + data.Persona.primer_nombre + " " + data.Persona.segundo_nombre + " - " + data.Persona.cedula};
                    callback(data);
                }
                );

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
}