import Calendar from "js-year-calendar";
import "js-year-calendar/dist/js-year-calendar.css";

let calendar = null;

document.addEventListener("DOMContentLoaded", (event) => {
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