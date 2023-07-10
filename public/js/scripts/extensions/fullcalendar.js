/*=========================================================================================
    File Name: fullcalendar.js
    Description: Fullcalendar
    --------------------------------------------------------------------------------------
    Item name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

document.addEventListener("DOMContentLoaded", function () {
  // color object for different event types
  var colors = {
    primary: "#7367f0",
    success: "#28c76f",
    danger: "#ea5455",
    warning: "#ff9f43",
  };

  // chip text object for different event types
  var categoryText = {
    primary: "Others/Initial Appointment",
    success: "Finished",
    danger: "Rejected",
    warning: "Pending",
  };
  var categoryBullets = $(".cal-category-bullets").html(),
    evtColor = "",
    eventColor = "";

  // calendar init
  var calendarEl = document.getElementById("fc-default");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    events: function (info, successCallback, failureCallback) {
      $.ajax({
        url: window.location.origin + "/schedules",
        dataType: "json",
        success: function (response) {
          var events = response.result.map(function (schedule) {
            return {
              schedule_id: schedule.survey_code,
              id: schedule.survey_code,
              survey_id: schedule.survey_id,
              title: schedule.schedule_title,
              start: schedule.start_date,
              end: schedule.end_date,
              className: schedule.classes,
              description: schedule.description,
              // url: 'http://127.0.0.1:8000/surveys/1/edit',
            };
          });
          successCallback(events);
        },
        error: function () {
          failureCallback();
        },
      });
    },

    // events: [
    //   {
    //     title: "event1",
    //     start: "2023-05-05",
    //     end: "2023-05-05",
    //     // color: '#28c76f',
    //     className:'chip-success',

    //   },
    // ],

    // var surveyIdList = document.getElementById("survey-id-list");
    // var desiredValue = "your_desired_value";

    // // Loop through the options
    // for (var i = 0; i < surveyIdList.options.length; i++) {
    //   var option = surveyIdList.options[i];

    //   if (option.value === desiredValue) {
    //     // Set the selected property of the option to true
    //     option.selected = true;
    //     break;
    //   }
    // }

    plugins: ["dayGrid", "timeGrid", "interaction"],
    customButtons: {
      addNew: {
        text: " Add",
        click: function () {
          var calDate = new Date(),
            todaysDate = calDate.toISOString().slice(0, 10);
          $(".modal-calendar").modal("show");
          $(".modal-calendar .cal-submit-event").addClass("d-none");
          $(".modal-calendar .remove-event").addClass("d-none");
          $(".modal-calendar .cal-add-event").removeClass("d-none");
          $(".modal-calendar .cancel-event").removeClass("d-none");
          $(".modal-calendar .add-category .chip").remove();
          $("#cal-start-date").val(todaysDate);
          $("#cal-end-date").val(todaysDate);
          $(".modal-calendar #cal-start-date").attr("disabled", false);
        },
      },
    },
    header: {
      left: "addNew",
      // center: "dayGridMonth,timeGridWeek,timeGridDay",
      center: "dayGridMonth",
      right: "prev,title,next",
    },
    displayEventTime: false,
    navLinks: true,
    editable: true,
    allDay: true,
    navLinkDayClick: function (date) {
      $(".modal-calendar").modal("show");
    },
    dateClick: function (info) {
      $(".modal-calendar #cal-start-date")
        .val(info.dateStr)
        .attr("disabled", true);
      $(".modal-calendar #cal-end-date").val(info.dateStr);
    },
    // displays saved event values on click
    eventClick: function (info) {
      var textcolor = "Others/Appointment";
      if (info.event.classNames[0] == "chip-blue") {
        textcolor = "Others/Appointment";
      }
      if (info.event.classNames[0] == "chip-warning") {
        textcolor = "Pending";
      }
      if (info.event.classNames[0] == "chip-danger") {
        textcolor = "Rejected";
      }
      if (info.event.classNames[0] == "chip-success") {
        textcolor = "Finished";
      }
      $(".modal-calendar").modal("show");
      $(".modal-calendar #cal-event-title").val(info.event.title);
      $(".modal-calendar #cal-start-date").val(
        moment(info.event.start).format("YYYY-MM-DD")
      );
      if (!info.event.end) {
        $(".modal-calendar #cal-end-date").val(
          moment(info.event.start).format("YYYY-MM-DD")
        );
      } else {
        $(".modal-calendar #cal-end-date").val(
          moment(info.event.end).format("YYYY-MM-DD")
        );
      }

      $(".modal-calendar #cal-description").val(
        info.event.extendedProps.description
      );
      $(".modal-calendar .cal-submit-event").removeClass("d-none");
      $(".modal-calendar .remove-event").removeClass("d-none");
      $(".modal-calendar .cal-add-event").addClass("d-none");
      $(".modal-calendar .cancel-event").addClass("d-none");
      $(".calendar-dropdown .dropdown-menu")
        .find(".selected")
        .removeClass("selected");
      // console.log(info.event.id);
      $("#survey-id-list").val(info.event.id).trigger("change");

      var eventCategory = info.event.extendedProps.dataEventColor;
      var eventText = categoryText[eventCategory];
      $(".modal-calendar .chip-wrapper .chip").remove();
      $(".modal-calendar .chip-wrapper").append(
        $(
          "<div class='chip " +
            info.event.classNames[0] +
            "'>" +
            "<div class='chip-body'>" +
            "<span class='chip-text'> " +
            textcolor +
            " </span>" +
            "</div>" +
            "</div>"
        )
      );
    },
  });

  // render calendar
  calendar.render();

  // appends bullets to left class of header
  $("#basic-examples .fc-right").append(categoryBullets);

  // Close modal on submit button
  $(".modal-calendar .cal-submit-event").on("click", function () {
    const survey_id_list = $("#survey-id-list").val();
    const event_title = $("#cal-event-title").val();
    const start_date = $("#cal-start-date").val();
    const end_date = $("#cal-end-date").val();
    const description = $("#cal-description").val();
    var chipElement = $(".chip-wrapper").find(".chip");
    var chipClass = chipElement.attr("class");
    // console.log('---------')
    // console.log(chipClass)
    // return false;
    // Create an object to hold the data
    const requestData = {
      survey_id: survey_id_list,
      schedule_title: event_title,
      date: start_date,
      end_date: end_date,
      description: description,
      classes: chipClass,
      schedule_type: "scheduled",
    };
    console.log(requestData);
    return false;
    // Retrieve CSRF token value from the page meta tag
    const csrfToken = $('meta[name="csrf-token"]').attr("content");

    // Add CSRF token to the request headers
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": csrfToken,
      },
    });

    // Make an API request when the button is clicked
    $.ajax({
      url: "/schedule_update",
      method: "POST", // Use POST method to send data
      data: requestData, // Pass the data object
      success: function (response) {
        // Process the API response
        console.log(response);
      },
      error: function (xhr, status, error) {
        console.log(xhr);
        console.log(status);

        // Handle errors
        console.log("API request failed:", error);
      },
    });

    $(".modal-calendar").modal("hide");
  });

  // Remove Event
  $(".remove-event").on("click", function () {
    var removeEvent = calendar.getEventById("newEvent");
    removeEvent.remove();
  });

  // reset input element's value for new event
  if ($("td:not(.fc-event-container)").length > 0) {
    $(".modal-calendar").on("hidden.bs.modal", function (e) {
      $(".modal-calendar .form-control").val("");
    });
  }
  $(".modal-calendar .modal-footer .btn").removeAttr("disabled");
  // remove disabled attr from button after entering info
  $(".modal-calendar .form-control").on("keyup", function () {
    if ($(".modal-calendar #cal-event-title").val().length >= 1) {
      $(".modal-calendar .modal-footer .btn").removeAttr("disabled");
    } else {
      // $(".modal-calendar .modal-footer .btn").attr("disabled", true);
    }
  });

  // open add event modal on click of day
  $(document).on("click", ".fc-day", function () {
    $(".modal-calendar").modal("show");
    $(".calendar-dropdown .dropdown-menu")
      .find(".selected")
      .removeClass("selected");
    $(".modal-calendar .cal-submit-event").addClass("d-none");
    $(".modal-calendar .remove-event").addClass("d-none");
    $(".modal-calendar .cal-add-event").removeClass("d-none");
    $(".modal-calendar .cancel-event").removeClass("d-none");
    $(".modal-calendar .add-category .chip").remove();
    $(".modal-calendar .modal-footer .btn").attr("disabled", true);
    evtColor = colors.primary;
    eventColor = "primary";
  });

  // change chip's and event's color according to event type
  $(".calendar-dropdown .dropdown-menu .dropdown-item").on(
    "click",
    function () {
      var selectedColor = $(this).data("color");
      evtColor = colors[selectedColor];
      eventTag = categoryText[selectedColor];
      eventColor = selectedColor;

      // changes event color after selecting category
      $(".cal-add-event").on("click", function () {
        calendar.addEvent({
          color: evtColor,
          dataEventColor: eventColor,
          className: eventColor,
        });
      });

      $(".calendar-dropdown .dropdown-menu")
        .find(".selected")
        .removeClass("selected");
      $(this).addClass("selected");

      // add chip according to category
      $(".modal-calendar .chip-wrapper .chip").remove();
      $(".modal-calendar .chip-wrapper").append(
        $(
          "<div class='chip chip-" +
            selectedColor +
            "'>" +
            "<div class='chip-body'>" +
            "<span class='chip-text'> " +
            eventTag +
            " </span>" +
            "</div>" +
            "</div>"
        )
      );
    }
  );

  // calendar add event
  $(".cal-add-event").on("click", function () {
    $(".modal-calendar").modal("hide");
    var eventTitle = $("#cal-event-title").val(),
      startDate = $("#cal-start-date").val(),
      endDate = $("#cal-end-date").val(),
      eventDescription = $("#cal-description").val(),
      correctEndDate = new Date(endDate);
    calendar.addEvent({
      id: "newEvent",
      title: eventTitle,
      start: startDate,
      end: correctEndDate,
      description: eventDescription,
      color: evtColor,
      dataEventColor: eventColor,
      allDay: true,
    });
  });

  // date picker
  $(".pickadate").pickadate({
    format: "yyyy-mm-dd",
  });
});
