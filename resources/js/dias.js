$(document).ready(function () {
    $("body").on("click", ".edit-btn", function () {
        var row = $(this).closest("tr");
        var diaId = $(this).data("id");


        var codigo = row.find(".codigo").text().trim();
        var nombre = row.find(".nombre").text().trim();
        var color = row.find(".color input").val();
        var fecha = row.find(".fecha").text().trim();
        var recurrente = row.find(".recurrente i").hasClass("bx-check") ? 1 : 0;
        
        $("#edit_id").val(codigo);
        $("#edit_nombre").val(nombre);
        $("#edit_color").val(color);
        $("#edit_fecha").val(fecha);
        $("#edit_recurrente").prop("checked", recurrente);

        $("#modalEditdia").modal("show");
    });

    $(".dia-delete-btn").on("click", (event) => {
        $("#dia_id").val($(event.currentTarget).val());
    });
});
