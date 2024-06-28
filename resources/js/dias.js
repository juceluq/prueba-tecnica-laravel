$(document).ready(function () {
    // Manejo de checkboxes de recurrente y anioGroup en el modal de edición
    $('#recurrente').on('change', function () {
        $('#anioGroup').toggle(!this.checked);
    });

    $('#edit_recurrente').on('change', function () {
        $('#edit_anioGroup').toggle(!this.checked);
    });

    // Mostrar modal de edición y llenar campos
    $('body').on('click', '.edit-btn', function () {
        var diaId = $(this).data('id');
        var row = $(this).closest('tr');

        var codigo = row.find('.codigo').text().trim();
        var nombre = row.find('.nombre').text().trim();
        var color = row.find('.color input').val();
        var fecha = row.find('.fecha').text().trim().split('/');
        var dia = fecha[0];
        var mes = fecha[1];
        var anio = fecha[2];
        var recurrente = row.find('.recurrente i').hasClass('bx-check');

        $('#edit_id').val(codigo);
        $('#edit_nombre').val(nombre);
        $('#edit_color').val(color);
        $('#edit_dia').val(dia);
        $('#edit_mes').val(mes);
        $('#edit_anio').val(anio);
        $('#edit_recurrente').prop('checked', recurrente).trigger('change');

        $('#modalEditdia').modal('show');
    });

    // Asignar valor al input hidden para eliminación
    $('.dia-delete-btn').on('click', function () {
        var diaId = $(this).val();
        $('#dia_delete_id').val(diaId);
    });
});
