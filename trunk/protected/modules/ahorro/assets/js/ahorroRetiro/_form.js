$(function () {
    $("#AhorroRetiro_socio_id").change(function () {
        var contenedor = $('#infoSocio');
        $.ajax({
//        type: "POST",
            url: baseUrl + 'ahorro/ahorroRetiro/ajaxInfoSocio/id/' + $(this).val(),
            beforeSend: function () {
                contenedor.html('');

                var html = "";
                html += "<div class='loading text-center'><img src='" + themeUrl + "images/truulo-loading.gif' /></div>";
                contenedor.html(html);
            },
            success: function (data) {
                contenedor.html('');
                contenedor.html(data);

            }
        });
    });
});