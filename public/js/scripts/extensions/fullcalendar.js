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
      const csrfToken = $('meta[name="csrf-token"]').attr("content");
      console.log('LODSCHED')
      // console.log(encodeString(csrfToken));

      $.ajax({
        url: window.location.origin + "/schedules?hash="+encodeString(csrfToken),
        dataType: "json",
        success: function (response) {
          var events = response.result.map(function (schedule) {
            console.log('LOAD SCHEDULES')
            console.log("LENGTH ", schedule.schedule_title.length);
            console.log(schedule)

            // Rejected
            // Success
            // Pending
            // Others/Appointments
            let scheduletitle = '';
            try {
              let truncatedString = schedule.survey_code.substring(0, 5);
              // scheduletitle = truncatedString + " " + schedule.schedule_title
              scheduletitle = schedule.survey_customer_name + " "+ truncatedString 
            } catch (error) {
              scheduletitle = schedule.schedule_title
              
            }


            var endDate = new Date(schedule.end_date);
            endDate.setDate(endDate.getDate() + 1);
             endDate = endDate.toISOString().split('T')[0];
            // console.log(endDate.toISOString().split('T')[0]);

            var transaction_amount = schedule.transaction_amount ?? ''; 
            var transaction_id = schedule.transaction_id ?? ''; 
            var transaction_status = schedule.transaction_status ?? ''; 
            
            // console.log(truncatedString)
            // console.log(truncatedString+' '+schedule.schedule_title)
            return {
              schedule_id_raw: schedule.id,
              remarks: schedule.remarks,

              schedule_id: schedule.survey_code,
              id: schedule.survey_code,
              survey_id: schedule.survey_id,
              title: scheduletitle,
              start: schedule.start_date,
              end: endDate,
              className: schedule.classes,
              description: schedule.description,
              transaction_amount: transaction_amount,
              transaction_id: transaction_id,
              transaction_status: transaction_status,
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
          console.log('show / add')
          $("#payment_amount").attr("readonly", false);
          $("#create_payment_link").show();
          $("#create_delete_link").hide();
          
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
      $(".modal-footer").show();
      $("#create_delete_link").hide();
      $("#payment_input").hide();
      $("#create_payment_link").show();
      $("#payment_amount").attr("readonly", false);
      console.log('show add')
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
      $(".modal-calendar #cal-remarks").val(
        info.event.extendedProps.remarks
      );
      $("#schedule_id_raw").val(info.event._def.extendedProps.schedule_id_raw);
      $(".modal-calendar .cal-submit-event").removeClass("d-none");
      $(".modal-calendar .remove-event").removeClass("d-none");
      $(".modal-calendar .cal-add-event").addClass("d-none");
      $(".modal-calendar .cancel-event").addClass("d-none");
      $(".calendar-dropdown .dropdown-menu")
        .find(".selected")
        .removeClass("selected");
      // console.log(info.event._def.extendedProps);
      $("#survey-id-list").val(info.event.id).trigger("change");
      
      var eventCategory = info.event.extendedProps.dataEventColor;
        // alert(eventCategory)
      // modal-footer
      // $(".modal-footer").css("display", "none");
      // $(".modal-footer").hide();
      $("#create_payment_link").show();
      $("#create_delete_link").show();
      // console.log(info.event.extendedProps.schedule_id_raw)
      $("#currentscheduleidselected").val(info.event.extendedProps.schedule_id_raw);

        console.log('EDIT')

        if(info.event._def.extendedProps.transaction_amount.length > 0){
          $("#payment_input").show();
          $("#payment_amount").val(info.event._def.extendedProps.transaction_amount);
          $("#create_payment_link").hide();
          $("#payment_amount").attr("readonly", true);
          
        }else{
          $("#payment_amount").attr("readonly", false);

        }
        var enddatedefaulting = $("#cal-end-date").val();


        if(enddatedefaulting.length > 0){
          // Create a Date object representing the desired date
          var currentDate = new Date($("#cal-end-date").val());
    
          // Subtract one day by using setDate() and getDate()
          currentDate.setDate(currentDate.getDate() - 1);
    
          // Format the resulting date as a string (e.g., "YYYY-MM-DD")
          var formattedDate = currentDate.toISOString().slice(0, 10);
          $("#cal-end-date").val(formattedDate)
        }


        // info.event._def.extendedProps.schedule_id_raw
        // info.event._def.extendedProps.schedule_id_raw
        console.log(info.event._def.extendedProps)
      console.log(info.event.end)
      if(info.event.extendedProps.length > 0){
        alert('zzz')
        console.log(info.event.extendedProps)
      }

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
    const schedule_id_raw = $("#schedule_id_raw").val();
    const survey_id_list = $("#survey-id-list").val();
    const event_title = $("#cal-event-title").val();
    const start_date = $("#cal-start-date").val();
    const end_date = $("#cal-end-date").val();
    const description = $("#cal-description").val();
    const remarks = $("#cal-remarks").val();
    const payment_amount = $("#payment_amount").val();
    var chipElement = $(".chip-wrapper").find(".chip");
    var chipClass = chipElement.attr("class");

    chipClass = chipClass.replace(/^chip /, '');


    // console.log('---------')
    // console.log(chipClass)
    // return false;
    // Create an object to hold the data
    const requestData = {
      schedule_id_raw: schedule_id_raw,
      survey_id: survey_id_list,
      schedule_id: event_title,
      schedule_title: event_title,
      date: start_date,
      end_date: end_date,
      description: description,
      remarks: remarks,
      classes: chipClass,
      payment_amount: payment_amount,
      schedule_type: "scheduled",
    };
    // Retrieve CSRF token value from the page meta tag
    const csrfToken = $('meta[name="csrf-token"]').attr("content");

    // Add CSRF token to the request headers
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": csrfToken,
      },
    });
    console.log(requestData);

    // Make an API request when the button is clicked
    $.ajax({
      url: "/schedule_update?hash" + encodeString(csrfToken),
      method: "POST", // Use POST method to send data
      data: requestData, // Pass the data object
      success: function (response) {
        // Process the API response
        console.log(response);
        location.reload();
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
    try {
      var removeEvent = calendar.getEventById("newEvent");
      removeEvent.remove();
    } catch (error) {
      
    }

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
    // click
    let clickedDate = $(this).data("date");
    let currentDate = new Date();
    let parsedClickedDate = new Date(clickedDate);

    // Compare the clicked date with the current date
    if (parsedClickedDate < currentDate) {
      // If the clicked date is in the past, do nothing (return) to prevent showing the modal
    }else{
      // $(".modal-footer").css("display", "none");
      $(".modal-footer").show();
      $(".modal-calendar").modal("show");
    }
    console.log('Day show')
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
      eventRemarks = $("#cal-remarks").val(),
      correctEndDate = new Date(endDate);
    calendar.addEvent({
      id: "newEvent",
      title: eventTitle,
      start: startDate,
      end: correctEndDate,
      description: eventDescription,
      description: eventRemarks,
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



$("#create_payment_link").click(function() {

  $("#payment_input").show();

});


function encodeString(input) {
  // Convert the input string to Base64
  const encoded = btoa(input);
  return encoded;
}