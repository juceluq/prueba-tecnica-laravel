$(document).ready(function () {

    function actualizarDias(mesInput, diaInput) {
        var mes = parseInt(mesInput.val(), 10);
        var maxDias = new Date($('#anio').val(), mes, 0).getDate();
        diaInput.attr('max', maxDias);
    }

    $('#recurrente').on('change', function () {
        $('#anioGroup').toggle(!this.checked);
        $('#anio').prop('required', !this.checked);
    });

    $('#edit_recurrente').on('change', function () {
        $('#edit_anioGroup').toggle(!this.checked);
        $('#edit_anio').prop('required', !this.checked);
    });

    $('.mes-input').on('change', function () {
        actualizarDias($(this), $('.dia-input'));
    });

    $('#modalEditdia').on('change', '.mes-input', function () {
        actualizarDias($(this), $('#edit_dia'));
    });

    $('body').on('click', '.edit-btn', function () {
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
    });

    // Capturar el ID del día a eliminar
    $('.dia-delete-btn').on('click', function () {
        var diaId = $(this).val();
        $('#dia_delete_id').val(diaId);
    });
});
