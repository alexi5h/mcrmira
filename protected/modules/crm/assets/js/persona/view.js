function showModalLoadingWidth() {
    var html = "";
    html += "<div class='modal-header'><a class='close' data-dismiss='modal'>&times;</a><h4><i class='icon-refresh'></i> Cargando</h4></div>";
    html += "<div class='loading'><img src='" + themeUrl + "images/truulo-loading.gif' /></div>";
    $("#mainModal").html(html);
    $("#mainModal").modal("show");
}

function showModalDataWidth(html) {

    $("#responsive").html(html);
    $("#responsive").modal("show");
    $('select.fix').selectBox();
}
/**
 * 
 * @param {cadena} url
 * @returns {undefined}
 */
function viewModalWidth(url, CallBack)
{
    $.ajax({
        type: "POST",
        url: baseUrl + url,
        beforeSend: function() {
            showModalLoadingWidth();
        },
        success: function(data) {
            $("#mainModal").modal("hide");
            showModalDataWidth(data);
            CallBack();

        }
    });
}