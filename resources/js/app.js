import "./bootstrap";
import "bootstrap";
import "@popperjs/core";
import Calendar from "js-year-calendar";
import "js-year-calendar/dist/js-year-calendar.css";

document.addEventListener("DOMContentLoaded", (event) => {
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);

        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener("click", () => {
                nav.classList.toggle("show");
                toggle.classList.toggle("bx-x");
                bodypd.classList.toggle("body-pd");
                headerpd.classList.toggle("body-pd");
                nav.classList.toggle("hide-elements");
            });
        }
    };

    $(".user-delete-btn").on("click", (event) => {
        console.log($(event.currentTarget).val());
        $("#user-id").val($(event.currentTarget).val());
    });
    
    $('.edit-btn').on('click', function() {
        var userId = $(this).data('id');
        var row = $(this).closest('tr');

        // Obtener los datos del usuario desde la fila
        var codigo = row.find('.codigo').text().trim();
        var login = row.find('.login').text().trim();
        var nombre = row.find('.nombre').text().trim();
        var apellidos = row.find('.apellidos').text().trim();
        var email = row.find('.email').text().trim();

        // Llenar los campos del modal de edición con los datos del usuario
        $('#edit_id').val(userId);
        $('#edit_codigo').val(codigo);
        $('#edit_login').val(login);
        $('#edit_nombre').val(nombre);
        $('#edit_apellidos').val(apellidos);
        $('#edit_email').val(email);

        // Mostrar el modal de edición
        $('#editEmployeeModal').modal('show');
    });
    

    showNavbar("header-toggle", "nav-bar", "body-pd", "header");

    const linkColor = document.querySelectorAll(".nav_link");

    linkColor.forEach((l) => l.addEventListener("click", colorLink));

    /* TODO Calendario */

    let calendar = null;

    $(() => {
        var currentYear = new Date().getFullYear();

        calendar = new Calendar("#calendar", {
            enableContextMenu: true,
            enableRangeSelection: true,
            contextMenuItems: [
                {
                    text: "Update",
                    click: editEvent,
                },
                {
                    text: "Delete",
                    click: deleteEvent,
                },
            ],
            selectRange: (e) => {
                editEvent({ startDate: e.startDate, endDate: e.endDate });
            },
            mouseOnDay: (e) => {
                if (e.events.length > 0) {
                    var content = "";

                    for (var i in e.events) {
                        content +=
                            '<div class="event-tooltip-content">' +
                            '<div class="event-name" style="color:' +
                            e.events[i].color +
                            '">' +
                            e.events[i].name +
                            "</div>" +
                            '<div class="event-location">' +
                            e.events[i].location +
                            "</div>" +
                            "</div>";
                    }

                    $(e.element).popover({
                        trigger: "manual",
                        container: "body",
                        html: true,
                        content: content,
                    });

                    $(e.element).popover("show");
                }
            },
            mouseOutDay: (e) => {
                if (e.events.length > 0) {
                    $(e.element).popover("hide");
                }
            },
            dayContextMenu: (e) => {
                $(e.element).popover("hide");
            },
        });

        $("#save-event").click(() => {
            saveEvent();
        });
    });
});

const colorLink = () => {
    if (linkColor) {
        linkColor.forEach((l) => l.classList.remove("active"));
        this.classList.add("active");
    }
};

const editEvent = (event) => {
    $('#event-modal input[name="event-index"]').val(event ? event.id : "");
    $('#event-modal input[name="event-name"]').val(event ? event.name : "");
    $('#event-modal input[name="event-location"]').val(
        event ? event.location : ""
    );
    $('#event-modal input[name="event-start-date"]').datepicker(
        "update",
        event ? event.startDate : ""
    );
    $('#event-modal input[name="event-end-date"]').datepicker(
        "update",
        event ? event.endDate : ""
    );
    $("#event-modal").modal("show");
};

const deleteEvent = (event) => {
    var dataSource = calendar.getDataSource();
    calendar.setDataSource(dataSource.filter((item) => item.id !== event.id));
};

const saveEvent = () => {
    var event = {
        id: $('#event-modal input[name="event-index"]').val(),
        name: $('#event-modal input[name="event-name"]').val(),
        location: $('#event-modal input[name="event-location"]').val(),
        startDate: $('#event-modal input[name="event-start-date"]').datepicker(
            "getDate"
        ),
        endDate: $('#event-modal input[name="event-end-date"]').datepicker(
            "getDate"
        ),
    };

    var dataSource = calendar.getDataSource();

    if (event.id) {
        for (var i in dataSource) {
            if (dataSource[i].id == event.id) {
                dataSource[i].name = event.name;
                dataSource[i].location = event.location;
                dataSource[i].startDate = event.startDate;
                dataSource[i].endDate = event.endDate;
            }
        }
    } else {
        var newId = 0;
        for (var i in dataSource) {
            if (dataSource[i].id > newId) {
                newId = dataSource[i].id;
            }
        }

        newId++;
        event.id = newId;
        dataSource.push(event);
    }

    calendar.setDataSource(dataSource);
    $("#event-modal").modal("hide");
};
