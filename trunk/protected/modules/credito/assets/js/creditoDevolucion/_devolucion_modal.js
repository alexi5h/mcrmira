function save() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: baseUrl + 'credito/creditoDevolucion/devolucion?id=' + devolucion_id,
        data: {'CreditoDevolucion': {
                'devolucion_id': devolucion_id
            }},
        beforeSend: function (xhr) {
        },
        success: function (data) {
            if (data.success) {
                $.fn.yiiGridView.update('credito-devolucion-grid');
                $("#mainModal").modal("hide");
                bootbox.alert(data.message);
            } else {
                $("#mainModal").modal("hide");
                bootbox.alert(data.message);
            }
        }
    });
}
