@extends('layouts/contentLayoutMaster')



@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/tether-theme-arrows.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/tether.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/shepherd-theme-default.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/fullcalendar.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/extensions/daygrid.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/extensions/timegrid.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/tour/tour.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('css/plugins/calendars/fullcalendar.css')) }}">
@endsection
<style>
    .hideitem {
        display: none;
    }

    .fc-center {}

    .payment_amount_prompt {
        display: none;
    }
</style>


@if ($access_level != 3)
    @section('title', 'Dashboard Analytics')

    @section('content')
        {{-- Dashboard Analytics Start --}}
        <section id="dashboard-analytics">

            <div class="row">


            </div>
            <div class="row ">
                {{-- match-height --}}
                <div class="col-lg-6 col-12 offset-lg-2">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h4>Survey Submissions</h4>
                            <div class="dropdown chart-dropdown">
                                <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span id="selectedFilterSS">Last 7 Days</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem2">
                                    <a class="dropdown-item" href="#" onclick="updateCounts(0,'ss')">Last 7 Days</a>
                                    <a class="dropdown-item" href="#" onclick="updateCounts(1,'ss')">Last 28 Days</a>
                                    <a class="dropdown-item" href="#" onclick="updateCounts(2,'ss')">Last Month</a>
                                    <a class="dropdown-item" href="#" onclick="updateCounts(3,'ss')">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="product-order-chart" class="mb-3"></div>
                                <div class="chart-info d-flex justify-content-between mb-1">
                                    <div class="series-info d-flex align-items-center">
                                        <i class="fa fa-circle-o text-bold-700 text-success"></i>
                                        <span class="text-bold-600 ml-50">Finished</span>
                                    </div>
                                    <div class="product-result">
                                        <span id="finishedCount">0</span>
                                    </div>
                                </div>
                                <div class="chart-info d-flex justify-content-between mb-1">
                                    <div class="series-info d-flex align-items-center">
                                        <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                        <span class="text-bold-600 ml-50">Pending</span>
                                    </div>
                                    <div class="product-result">
                                        <span id="pendingCount">0</span>
                                    </div>
                                </div>
                                <div class="chart-info d-flex justify-content-between mb-75">
                                    <div class="series-info d-flex align-items-center">
                                        <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                        <span class="text-bold-600 ml-50">Rejected</span>
                                    </div>
                                    <div class="product-result">
                                        <span id="rejectedCount">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-2 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h4 class="card-title">Worker Count</h4>
                            <div class="dropdown chart-dropdown">
                                <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem4"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" hidden>
                                    Last 7 Days
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">
                                    <a class="dropdown-item" href="#">Last 28 Days</a>
                                    <a class="dropdown-item" href="#">Last Month</a>
                                    <a class="dropdown-item" href="#">Last Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-12 d-flex flex-column flex-wrap text-center">
                                        <h1 class="font-large-2 text-bold-700 mt-2 mb-0">{{ $workerCount }}</h1>
                                        <small>Worker</small>
                                    </div>
                                    {{-- <div class="col-sm-10 col-12 d-flex justify-content-center">
                                    <div id="support-tracker-chart"></div>
                                </div> --}}
                                </div>
                                {{-- <div class="chart-info d-flex justify-content-between" >
                                <div class="text-center">
                                    <p class="mb-50">New Tickets</p>
                                    <span class="font-large-1">29</span>
                                </div>
                                <div class="text-center">
                                    <p class="mb-50">Open Tickets</p>
                                    <span class="font-large-1">63</span>
                                </div>
                                <div class="text-center">
                                    <p class="mb-50">Response Time</p>
                                    <span class="font-large-1">1d</span>
                                </div>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </section>
        <!-- Dashboard Analytics end -->

        <!-- Full calendar start -->
        <section id="basic-examples">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="cal-category-bullets d-none">
                                    <div class="bullets-group-1 mt-2">
                                        <div class="category-business mr-1">
                                            <span class="bullet bullet-blue bullet-sm mr-25"></span>
                                            Initial Appointment
                                        </div>
                                        <div class="category-business mr-1">
                                            <span class="bullet bullet-success bullet-sm mr-25"></span>
                                            Finished
                                        </div>
                                        <div class="category-work mr-1">
                                            <span class="bullet bullet-warning bullet-sm mr-25"></span>
                                            Pending
                                        </div>
                                        <div class="category-personal mr-1">
                                            <span class="bullet bullet-danger bullet-sm mr-25"></span>
                                            Rejected
                                        </div>
                                        {{-- <div class="category-others">
                  <span class="bullet bullet-primary bullet-sm mr-25"></span>
                  Others
                </div> --}}
                                    </div>
                                </div>
                                <div id='fc-default'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- calendar Modal starts-->
            <div class="modal fade text-left modal-calendar" tabindex="-1" role="dialog" aria-labelledby="cal-modal"
                aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-text-bold-600" id="cal-modal">
                                {{-- title --}}

                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <form action="#">


                            <div class="modal-body">
                                <div class="d-flex justify-content-between align-items-center add-category">
                                    <p>Select Category</p>
                                    <div id="classes" class="chip-wrapper"></div>
                                    <div class="label-icon pt-1 pb-2 dropdown calendar-dropdown">
                                        <i class="feather icon-tag dropdown-toggle" id="cal-event-category"
                                            data-toggle="dropdown"></i>
                                        <div class="dropdown-menu dropdown-menu-right"
                                            aria-labelledby="cal-event-category">
                                            <span class="dropdown-item business" data-color="success">
                                                <span class="bullet bullet-success bullet-sm mr-25"></span>
                                                Finished
                                            </span>
                                            <span class="dropdown-item work" data-color="warning">
                                                <span class="bullet bullet-warning bullet-sm mr-25"></span>
                                                Pending
                                            </span>
                                            <span class="dropdown-item personal" data-color="danger">
                                                <span class="bullet bullet-danger bullet-sm mr-25"></span>
                                                Rejected
                                            </span>
                                            <span class="dropdown-item others" data-color="primary">
                                                <span class="bullet bullet-primary bullet-sm mr-25"></span>
                                                Initial Appointment
                                            </span>
                                            <span class="dropdown-item others" data-color="primary">
                                                <span class="bullet bullet-primary bullet-sm mr-25"></span>
                                                Others
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <fieldset class="form-label-group">
                                    <select class="select2 form-control" id="survey-id-list">
                                        <option value="">Select Survey ID</option>
                                        @foreach ($survey_ids as $value)
                                            <option value="{{ $value }}">
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>


                                <fieldset class="form-label-group" hidden>
                                    <input type="text" class="form-control" id="schedule_id"
                                        placeholder="Event Title">
                                    <label for="schedule_id">Event ID</label>
                                </fieldset>

                                <fieldset class="form-label-group" hidden>
                                    <input type="text" class="form-control" id="schedule_id_raw"
                                        placeholder="Event Title">
                                    <label for="schedule_id">Schedule ID raw</label>
                                </fieldset>
                                <fieldset class="form-label-group">
                                    <input type="text" class="form-control" id="cal-event-title"
                                        placeholder="Event Title">
                                    <label for="cal-event-title">Event Title</label>
                                </fieldset>
                                <fieldset class="form-label-group">
                                    <input type="text" class="form-control pickadate" id="cal-start-date"
                                        placeholder="Start Date">
                                    <label for="cal-start-date">Start Date</label>
                                </fieldset>
                                <fieldset class="form-label-group">
                                    <input type="text" class="form-control pickadate" id="cal-end-date"
                                        placeholder="End Date">
                                    <label for="cal-end-date">End Date</label>
                                </fieldset>
                                <fieldset class="form-label-group">
                                    <textarea class="form-control" id="cal-description" rows="5" placeholder="Description"></textarea>
                                    <label for="cal-description">Description</label>
                                </fieldset>
                                <fieldset class="form-label-group">
                                    <textarea class="form-control" id="cal-remarks" rows="5" placeholder="Remarks"></textarea>
                                    <label for="cal-description">Remarks</label>
                                </fieldset>

                                <fieldset id="payment_input" class="form-label-group payment_amount_prompt">
                                    <p>Payment Amount</p>
                                    <input type="numeric" class="form-control" id="payment_amount" placeholder="0.00">
                                    <label for="payment_amount">Payment Amount</label>
                                </fieldset>

                            </div>
                            <div class="modal-footer">
                                <a id="create_payment_link" style="color:white !important;"
                                    class="btn btn-primary waves-effect waves-light">
                                    Create Payment</a>
                                <a id="create_delete_link" style="color:white !important;"
                                    class="btn btn-danger waves-effect waves-light">
                                    Delete Schedule</a>
                                <input type="text" hidden id="currentscheduleidselected">
                                <button id="add_schedule" type="button"
                                    class="btn btn-primary cal-add-event waves-effect waves-light">
                                    Add Schedule</button>
                                <button type="button"
                                    class="btn btn-primary d-none cal-submit-event waves-effect waves-light"
                                    disabled>submit</button>
                                <button type="button" class="btn btn-flat-danger cancel-event waves-effect waves-light"
                                    data-dismiss="modal">Cancel</button>
                                <button type="button"
                                    class="btn btn-flat-danger remove-event d-none waves-effect waves-light"
                                    data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- calendar Modal ends-->
        </section>
        <!-- // Full calendar end -->
        <div>
            <input type="text" id="finishedSurveyCount" hidden value="{{ $finishedSurveyCount }}">
            <input type="text" id="pendingSurveyCount" hidden value="{{ $pendingSurveyCount }}">
            <input type="text" id="rejectedSurveyCount" hidden value="{{ $rejectedSurveyCount }}">
            <input type="text" id="totalSurveyCount" hidden value="{{ $totalSurveyCount }}">
            <input type="text" id="finishedSurveyPercentage" hidden value="{{ $finishedSurveyPercentage }}">
            <input type="text" id="pendingSurveyPercentage" hidden value="{{ $pendingSurveyPercentage }}">
            <input type="text" id="rejectedSurveyPercentage" hidden value="{{ $rejectedSurveyPercentage }}">

        </div>
    @endsection

    @section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/extensions/tether.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/extensions/shepherd.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/calendar/fullcalendar.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/calendar/extensions/daygrid.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/calendar/extensions/timegrid.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/calendar/extensions/interactions.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>

        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
    @endsection

    @section('page-script')
        <!-- Page js files -->
        {{-- <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script> --}}
        <script src="{{ asset(mix('js/scripts/extensions/fullcalendar.js')) }}"></script>

        <script>
            let finishedSurveyCount = $('#finishedSurveyCount').val();
            let pendingSurveyCount = $('#pendingSurveyCount').val();
            let rejectedSurveyCount = $('#rejectedSurveyCount').val();
            let totalSurveyCount = $('#totalSurveyCount').val();
            let finishedSurveyPercentage = $('#finishedSurveyPercentage').val();
            let pendingSurveyPercentage = $('#pendingSurveyPercentage').val();
            let rejectedSurveyPercentage = $('#rejectedSurveyPercentage').val();
            $('#finishedCount').html(finishedSurveyCount);
            $('#pendingCount').html(pendingSurveyCount);
            $('#rejectedCount').html(rejectedSurveyCount);
            // $('#create_delete_link').hide();

            function getFinishedSurveyCount() {
                return finishedSurveyCount;
            }

            function setFinishedSurveyCount(value) {
                finishedSurveyCount = value;
            }

            function getPendingSurveyCount() {
                return pendingSurveyCount;
            }

            function setPendingSurveyCount(value) {
                pendingSurveyCount = value;
            }

            function getRejectedSurveyCount() {
                return rejectedSurveyCount;
            }

            function setRejectedSurveyCount(value) {
                rejectedSurveyCount = value;
            }

            function getTotalSurveyCount() {
                return totalSurveyCount;
            }

            function setTotalSurveyCount(value) {
                totalSurveyCount = value;
            }

            function getFinishedSurveyPercentage() {
                return finishedSurveyPercentage;
            }

            function setFinishedSurveyPercentage(value) {
                finishedSurveyPercentage = value;
            }

            function getPendingSurveyPercentage() {
                return pendingSurveyPercentage;
            }

            function setPendingSurveyPercentage(value) {
                pendingSurveyPercentage = value;
            }

            function getRejectedSurveyPercentage() {
                return rejectedSurveyPercentage;
            }

            function setRejectedSurveyPercentage(value) {
                rejectedSurveyPercentage = value;
            }








            /*=========================================================================================
                File Name: dashboard-analytics.js
                Description: dashboard analytics page content with Apexchart Examples
                ----------------------------------------------------------------------------------------
                Item name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
                Author: PIXINVENT
                Author URL: http://www.themeforest.net/user/pixinvent
            ==========================================================================================*/

            // $(window).on("load", function() {

            var $primary = '#7367F0';
            var $danger = '#EA5455';
            var $warning = '#FF9F43';
            var $info = '#0DCCE1';
            var $sucess = '#28c76f';
            var $primary_light = '#8F80F9';
            var $warning_light = '#FFC085';
            var $danger_light = '#f29292';
            var $info_light = '#1edec5';
            var $strok_color = '#b9c3cd';
            var $label_color = '#e7eef7';
            var $white = '#fff';






            function chartRun() {
                // Avg Session Chart ends //


                // Support Tracker Chart starts
                // -----------------------------

                var supportChartoptions = {
                    chart: {
                        height: 270,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            size: 150,
                            startAngle: -150,
                            endAngle: 150,
                            offsetY: 20,
                            hollow: {
                                size: '65%',
                            },
                            track: {
                                background: $white,
                                strokeWidth: '100%',

                            },
                            dataLabels: {
                                value: {
                                    offsetY: 30,
                                    color: '#99a2ac',
                                    fontSize: '2rem'
                                }
                            }
                        },
                    },
                    colors: [$danger],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            // enabled: true,
                            shade: 'dark',
                            type: 'horizontal',
                            shadeIntensity: 0.5,
                            gradientToColors: [$primary],
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        },
                    },
                    stroke: {
                        dashArray: 8
                    },
                    series: [83],
                    labels: ['Completed Tickets'],

                }

                var supportChart = new ApexCharts(
                    document.querySelector("#support-tracker-chart"),
                    supportChartoptions
                );

                supportChart.render();

                // Support Tracker Chart ends


                // Product Order Chart starts
                // -----------------------------

                var productChartoptions = {
                    chart: {
                        height: 325,
                        type: 'radialBar',
                    },
                    colors: [$sucess, $warning, $danger],
                    fill: {
                        type: 'solid',
                        gradient: {
                            // enabled: true,
                            shade: 'dark',
                            type: 'vertical',
                            shadeIntensity: 0.5,
                            // gradientToColors: [$primary_light, $warning_light, $danger_light],
                            gradientToColors: [$sucess],
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        },
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    plotOptions: {
                        radialBar: {
                            size: 165,
                            hollow: {
                                size: '20%'
                            },
                            track: {
                                strokeWidth: '100%',
                                margin: 15,
                            },
                            dataLabels: {
                                name: {
                                    fontSize: '18px',
                                },
                                value: {
                                    fontSize: '16px',
                                },
                                total: {
                                    show: true,
                                    label: 'Total',

                                    formatter: function(w) {
                                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                        return totalSurveyCount
                                    }
                                }
                            }
                        }
                    },
                    series: [finishedSurveyPercentage, pendingSurveyPercentage, rejectedSurveyPercentage],
                    labels: ['Finished', 'Pending', 'Rejected'],

                }

                var productChart = new ApexCharts(
                    document.querySelector("#product-order-chart"),
                    productChartoptions
                );

                productChart.render();

                // Product Order Chart ends //





            }

            chartRun();
            // });
            function updateCounts(status, mode) {


                // Make a request to the API with the provided status
                fetch('/filter_analytics?status=' + status)
                    .then(response => response.json())
                    .then(data => {
                        // return false;
                        const totalSurveyCount = data.finishedSurveyCount + data.pendingSurveyCount + data
                            .rejectedSurveyCount;

                        setFinishedSurveyCount(data.finishedSurveyCount)
                        setPendingSurveyCount(data.pendingSurveyCount)
                        setRejectedSurveyCount(data.rejectedSurveyCount)
                        setTotalSurveyCount(totalSurveyCount)

                        setFinishedSurveyPercentage(data.finishedSurveyPercentage)
                        setPendingSurveyPercentage(data.pendingSurveyPercentage)
                        setRejectedSurveyPercentage(data.rejectedSurveyPercentage)

                        $('#finishedCount').html(finishedSurveyCount);
                        $('#pendingCount').html(pendingSurveyCount);
                        $('#rejectedCount').html(rejectedSurveyCount);

                        if (mode == 'ss') {
                            if (status == 0) {
                                $('#selectedFilterSS').html('Last 7 Days');
                            }
                            if (status == 1) {
                                $('#selectedFilterSS').html('Last 28 Days');

                            }
                            if (status == 2) {
                                $('#selectedFilterSS').html('Last Month');
                            }
                            if (status == 3) {
                                $('#selectedFilterSS').html('Last Year');

                            }


                        }

                    })
                    .catch(error => console.error(error));

                chartRun();

            }
        </script>

        <script>
            $(document).ready(function() {
                $('#add_schedule').click(function() {
                    $(".modal-calendar .modal-footer .btn").removeAttr("disabled");
                    const survey_id_list = $('#survey-id-list').val();
                    const event_title = $('#cal-event-title').val();
                    const start_date = $('#cal-start-date').val();
                    const end_date = $('#cal-end-date').val();
                    const description = $('#cal-description').val();
                    const remarks = $('#cal-remarks').val();
                    const payment_amount = $('#payment_amount').val();
                    var chipElement = $('.chip-wrapper').find('.chip');
                    var chipClass = chipElement.attr('class');
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
                        remarks: remarks,
                        classes: chipClass,
                        schedule_type: 'scheduled',
                        payment_amount: payment_amount,

                    };
                    // Retrieve CSRF token value from the page meta tag
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // Add CSRF token to the request headers
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    // Make an API request when the button is clicked
                    $.ajax({
                        url: '/schedule_insert',
                        method: 'POST', // Use POST method to send data
                        data: requestData, // Pass the data object
                        success: function(response) {
                            // Process the API response
                            console.log(response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            console.log(status);

                            // Handle errors
                            console.log('API request failed:', error);
                        }
                    });

                });

            });




            // Wait for the DOM content to load
            document.addEventListener("DOMContentLoaded", function() {
                const addButton = document.getElementById("create_payment_link");
                const paymentInput = document.getElementById("payment_input");
                const paymentAmountInput = document.getElementById("payment_amount");

                addButton.addEventListener("click", function() {
                    if (paymentInput.classList.contains("payment_amount_prompt")) {
                        // Remove the payment_amount_prompt class to hide the fieldset
                        paymentInput.classList.remove("payment_amount_prompt");
                        // Set the payment_amount input value to blank
                        paymentAmountInput.value = "";
                        // addButton.textContent = "Add Schedule";
                    } else {
                        // Add the payment_amount_prompt class to show the fieldset
                        paymentInput.classList.add("payment_amount_prompt");
                        addButton.textContent = "Create Payment";
                    }
                });

                $("#create_delete_link").click(function() {
                    // This function will be executed when the button is clicked

                    $.ajax({
                        url: "/schedule_delete",
                        method: "POST",
                        data: $("#currentscheduleidselected").val(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Get the CSRF token value from the meta tag
                        },
                        success: function(response) {
                            console.log(response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log("API request failed:", error);
                        },
                    });




                });

                // const deleteSchedule = document.getElementById("create_delete_link");

                // deleteSchedule.addEventListener("click", function() {

                //     return false;
                //     $.ajax({
                //         url: "/schedule_delete",
                //         method: "POST", // Use POST method to send data
                //         data: currentscheduleidselected, // Pass the data object
                //         success: function(response) {
                //             // Process the API response
                //             console.log(response);
                //             location.reload();
                //         },
                //         error: function(xhr, status, error) {
                //             console.log(xhr);
                //             console.log(status);

                //             // Handle errors
                //             console.log("API request failed:", error);
                //         },
                //     });

                //     $(".modal-calendar").modal("hide");
                // });

                // // if (paymentInput.classList.contains("payment_amount_prompt")) {
                // //     // Remove the payment_amount_prompt class to hide the fieldset
                // //     paymentInput.classList.remove("payment_amount_prompt");
                // //     // Set the payment_amount input value to blank
                // //     paymentAmountInput.value = "";
                // //     // addButton.textContent = "Add Schedule";
                // // } else {
                // //     // Add the payment_amount_prompt class to show the fieldset
                // //     paymentInput.classList.add("payment_amount_prompt");
                // //     addButton.textContent = "Create Payment";
                // // }
                // });



            });
        </script>
    @endsection
@endif
@if ($access_level == 3)
    <input id="acclvl" type="text" value="{{ $access_level }}" hidden>

    @section('page-script')
        <script>
            window.location.href = "/survey_history";
        </script>
    @endsection
@endif
