$(function(){
    //#74B749
    $("#wrapper_grid_ahorro").niceScroll({styler: "fb", cursorcolor: "#74B749", cursorwidth: '8', cursorborderradius: '0px', background: '#404040', cursorborder: '', zindex: '1000'});
    $("#wrapper-deposito").niceScroll({styler: "fb", cursorcolor: "#34AFBD", cursorwidth: '8', cursorborderradius: '0px', background: '#404040', cursorborder: '', zindex: '1000'});

})
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