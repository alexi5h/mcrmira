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
function viewModalWidth(url, CallBack)
{
    window.console.log(url);

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
        $.fn.yiiGridView.update('ahorro-deposito-grid');
    });
    $(".modal-footer>a.btn").click(function () {
        $.fn.yiiGridView.update('ahorro-deposito-grid');
    });
    $("#buttondeposito>a.btn-success").click(function () {
        $.fn.yiiGridView.update('ahorro-deposito-grid');
    });
}