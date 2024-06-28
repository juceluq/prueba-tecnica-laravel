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
            clickDay: addEvent,
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

                        if (i < e.events.length - 1) {
                            content += "<hr>";
                        }
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
                                recurrente: dia.recurrente,
                            });
                        }
                    } else {
                        diasFestivos.push({
                            id: dia.id,
                            name: dia.nombre,
                            color: dia.color,
                            startDate: new Date(dia.anio, dia.mes - 1, dia.dia),
                            endDate: new Date(dia.anio, dia.mes - 1, dia.dia),
                            recurrente: dia.recurrente,
                        });
                    }
                });

                calendar.setDataSource(diasFestivos);
            },
            error: (error) => {
                console.error("Error cargando días festivos:", error);
            },
        });

        
    });
});

const addEvent = (event) => {
    console.log(event);
    $('#modalAddDia input[name="dia"]').val(event ? event.date.getDate() : "");
    $('#modalAddDia input[name="mes"]').val(event ? event.date.getMonth()+1 : "");
    $('#modalAddDia input[name="anio"]').val(event ? event.date.getFullYear() : "");
    $("#modalAddDia").modal("show");
};

const editEvent = (event) => {
    $('#event-modal input[name="edit_id"]').val(event ? event.id : "");
    $('#event-modal input[name="edit_nombre"]').val(event ? event.name : "");
    $('#event-modal input[name="edit_color"]').val(event ? event.color : "");
    $('#event-modal input[name="edit_dia"]').val(
        event ? event.startDate.getDate() : ""
    );
    $('#event-modal input[name="edit_mes"]').val(
        event ? event.startDate.getMonth() + 1 : ""
    );
    $('#event-modal input[name="edit_anio"]').val(
        event ? event.startDate.getFullYear() : ""
    );
    $('#event-modal input[name="edit_recurrente"]').val(
        event.recurrente === 1 ? 1 : 0
    );

    $("#event-modal").modal("show");
};

const deleteEvent = (event) => {
    $('#modalDeletedia input[name="dia_delete_id"]').val(event.id);
    $("#modalDeletedia").modal("show");
};


