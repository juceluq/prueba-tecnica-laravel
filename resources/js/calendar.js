import Calendar from "js-year-calendar";
import "js-year-calendar/dist/js-year-calendar.css";
import "js-year-calendar/locales/js-year-calendar.es";

document.addEventListener("DOMContentLoaded", (event) => {
    $(() => {
        let calendar = new Calendar("#calendar", {
            enableContextMenu: true,
            language: "es",
            contextMenuItems: [
                {
                    text: "Actualizar",
                    click: editEvent,
                },
                {
                    text: "Eliminar",
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

        const years = 50;
        $.ajax({
            url: "/api/dias-festivos",
            method: "GET",
            success: (data) => {
                const diasFestivos = [];
                const currentYear = new Date().getFullYear();

                data.forEach((dia) => {
                    if (dia.recurrente === 1) {
                        const startYear = currentYear - years;
                        const endYear = currentYear + years;

                        for (let year = startYear; year <= endYear; year++) {
                            diasFestivos.push({
                                id: dia.id,
                                name: dia.nombre,
                                color: dia.color,
                                startDate: new Date(year, dia.mes - 1, dia.dia),
                                endDate: new Date(year, dia.mes - 1, dia.dia),
                            });
                        }
                    } else {
                        diasFestivos.push({
                            id: dia.id,
                            name: dia.nombre,
                            color: dia.color,
                            startDate: new Date(dia.anio, dia.mes - 1, dia.dia),
                            endDate: new Date(dia.anio, dia.mes - 1, dia.dia),
                        });
                    }
                });

                calendar.setDataSource(diasFestivos);
            },
            error: (error) => {
                console.error("Error cargando días festivos:", error);
            },
        });

        $("#save-event").click(() => {
            saveEvent();
        });
    });
});

const editEvent = (event) => {
    $('#event-modal input[name="edit_id"]').val(event ? event.id : "");
    $('#event-modal input[name="edit_nombre"]').val(event ? event.name : "");
    $('#event-modal input[name="edit_color"]').val(
        event ? event.color : ""
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
