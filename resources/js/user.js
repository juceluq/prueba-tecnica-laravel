$(document).ready(function () {
    $("body").on("click", ".edit-btn", function () {
        var userId = $(this).data("id");
        var row = $(this).closest("tr");

        var codigo = row.find(".codigo").text().trim();
        var login = row.find(".login").text().trim();
        var nombre = row.find(".nombre").text().trim();
        var apellidos = row.find(".apellidos").text().trim();
        var email = row.find(".email").text().trim();

        document.querySelector("#edit_id").value = userId;
        document.querySelector("#edit_codigo").value = codigo;
        document.querySelector("#edit_login").value = login;
        document.querySelector("#edit_nombre").value = nombre;
        document.querySelector("#edit_apellidos").value = apellidos;
        document.querySelector("#edit_email").value = email;
        document.querySelector("#edit_id").action = `/usuario/${userId}`;

        $("#editEmployeeModal").modal("show");
    });

    $(".user-delete-btn").on("click", (event) => {
        $("#user-id").val($(event.currentTarget).val());
    });

});

