@extends('layouts/contentLayoutMaster')

@section('title', $title)
@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

@endsection


@section('content')
    <style type="text/css">
        .div-upload {
            display: none;
        }

        .scrollable-area {
            height: 150px;
            overflow-y: auto;
        }
    </style>
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $mode }} {{ $title }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" enctype="multipart/form-data" method="POST"
                                action="{{ $mode == 'Update' ? route('survey_history.update', $edit->id) : route('survey_history.store') }}">
                                @csrf <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Name</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $mode == 'Update' ? $edit->name : old('name') }}"
                                                    autocomplete="name" autofocus> @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($mode == 'Update')
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Survey ID</span>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="position-relative has-icon-left">
                                                    <input id="survey_id" type="text"
                                                        class="form-control @error('survey_id') is-invalid @enderror"
                                                        value="{{ $mode == 'Update' ? $edit->survey_id : old('survey_id') }}"
                                                        autocomplete="survey_id" readonly> @error('survey_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Email Address</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="email_address" type="email"
                                                    class="form-control @error('email_address') is-invalid @enderror"
                                                    name="email_address"
                                                    value="{{ $mode == 'Update' ? $edit->email_address : old('email_address') }}"
                                                    autocomplete="email_address" autofocus> @error('email_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Mobile Number</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="mobile_number" type="text"
                                                    class="form-control @error('mobile_number') is-invalid @enderror"
                                                    name="mobile_number"
                                                    value="{{ $mode == 'Update' ? $edit->mobile_number : old('mobile_number') }}"
                                                    autocomplete="mobile_number" autofocus> @error('mobile_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Estimated Sqm.</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="sqm_estimation" type="text"
                                                    class="form-control @error('sqm_estimation') is-invalid @enderror"
                                                    name="sqm_estimation"
                                                    value="{{ $mode == 'Update' ? $edit->sqm_estimation : old('sqm_estimation') }}"
                                                    autocomplete="sqm_estimation" autofocus> @error('sqm_estimation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Schedule</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                @if ($mode == 'Update')
                                                    <input readonly class="form-control" type="text"
                                                        value="{{ $mode == 'Update' ? @$edit->date : old('date') }}">
                                                @endif

                                                @if ($mode != 'Update')
                                                    <input type="text" name="requested_schedule" id="from"
                                                        class="form-control format-picker-new-date"
                                                        placeholder="MM-DD-YYYY">
                                                @endif


                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span></span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                @if ($mode != 'Update')
                                                    <input type="file" name="customer_survey_files[]" multiple
                                                        value="{{ $mode == 'Update' ? @$edit->customer_survey_files : old('customer_survey_files') }}">
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($mode == 'Update')
                                    @method('PUT') <input id="id" type="hidden" name="id"
                                        value="{{ $mode == 'Update' ? $edit->id : '' }}">
                                    <input id="scheduled_date" type="hidden"
                                        value="{{ $mode == 'Update' ? $edit->date : '' }}">
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="font-weight:bold;">Booked Schedules</p>
                                        <hr>
                                        <input id="other_schedules" type="text" class="form-control" hidden
                                            value="{{ $mode == 'Update' ? @$edit->other_schedules : old('other_schedules') }}">
                                        <div id="booked_schedule_area" class="scrollable-area"></div>
                                    </div>
                                </div>


                                <div class="row">
                                    <input id="customer_survey_files" type="text" hidden class="form-control"
                                        value="{{ $mode == 'Update' ? @$edit->customer_survey_files : old('customer_survey_files') }}">
                                    <div class="col-md-6">
                                        <p style="font-weight:bold;">Customer Uploaded Files</p>
                                        <hr>
                                        <div id="customer_survey_area"></div>
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-3">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        </div>
                                        <div class="col-md-1 offset-md-8">
                                            <a href="{{ route('survey_history.index') }}"
                                                class="btn btn-primary mr-1 mb-1">Back</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section hidden id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Transaction Logs</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

@endsection

@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/pickers/dateTime/pick-a-datetime.js')) }}"></script>
<script>
    let surveyPricingDetails = [];
    const surveyPricing = $("#survey_pricing_details").val();
    if (surveyPricing) {
        surveyPricingDetails = JSON.parse(surveyPricing);
    } else {
        surveyPricingDetails = [{
                name: "parcellary",
                value: "0.00"
            },
            {
                name: "topographic",
                value: "0.00"
            },
            {
                name: "relocation",
                value: "0.00"
            },
            {
                name: "hydro",
                value: "0.00"
            },
        ];
    }

    function updateSurveyPricingFields() {
        $("#topographic").val(Number(surveyPricingDetails.find(item => item.name === 'topographic').value).toFixed(2));
        $("#parcellary").val(Number(surveyPricingDetails.find(item => item.name === 'parcellary').value).toFixed(2));
        $("#relocation").val(Number(surveyPricingDetails.find(item => item.name === 'relocation').value).toFixed(2));
        $("#hydro").val(Number(surveyPricingDetails.find(item => item.name === 'hydro').value).toFixed(2));
        $("#survey_pricing_details").val(JSON.stringify(surveyPricingDetails));

    }

    updateSurveyPricingFields();

    $("#update_price").click(function() {
        Swal.fire({
            title: "<strong>Survey Price</strong>",
            icon: "info",
            html: '<div style="text-align:left"><p>Topographic: <input id="update_topographic" type="text" class="form-control" name="update_topographic" autocomplete="" autofocus value="' +
                surveyPricingDetails.find(item => item.name === 'topographic').value +
                '">' +
                '<br>' +
                '<p>Parcellary: <input id="update_parcellary" type="text" class="form-control" name="update_parcellary" autocomplete="" autofocus value="' +
                surveyPricingDetails.find(item => item.name === 'parcellary').value +
                '">' +
                '<br>' +
                '<p>Relocation: <input id="update_relocation" type="text" class="form-control" name="update_relocation" autocomplete="" autofocus value="' +
                surveyPricingDetails.find(item => item.name === 'relocation').value +
                '">' +
                '<br>' +
                '<p>Hydro: <input id="update_hydro" type="text" class="form-control" name="update_hydro" autocomplete="" autofocus value="' +
                surveyPricingDetails.find(item => item.name === 'hydro').value +
                '">' +
                '<br></div>',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "Update",
            cancelButtonText: "Cancel",
            preConfirm: () => {
                // Get the values from the updated form
                surveyPricingDetails.find(item => item.name === 'parcellary').value = $(
                    '#update_parcellary').val();
                surveyPricingDetails.find(item => item.name === 'topographic').value = $(
                    '#update_topographic').val();
                surveyPricingDetails.find(item => item.name === 'relocation').value = $(
                    '#update_relocation').val();
                surveyPricingDetails.find(item => item.name === 'hydro').value = $('#update_hydro')
                    .val();
                // Update the form fields
                updateSurveyPricingFields();
            },
        }).then((result) => {
            console.log(result)
            if (result.value) {
                Swal.fire("Saved!", "", "success");
            } else if (!result.value) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });

    $("#create_payment").click(function() {



        Swal.fire({
            title: 'Request Payment Amount',
            input: 'number',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            showLoaderOnConfirm: true,
            preConfirm: (input) => {

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var data_id = $("#id").val();

                // Make the POST request with the CSRF token included
                $.ajax({
                    url: window.location.origin + "/transactions",
                    type: "POST",
                    data: {
                        amount: input,
                        survey_id: data_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
                    },
                    success: function(data) {
                        console.log("Transaction added successfully:", data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error adding transaction:", errorThrown);
                    }
                });

            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            console.log(result)
        })
    })



    // Swal.fire({
    //     title: 'HTML Content',
    //     html: '<h2>This is an example</h2><p>You can include HTML content within the SweetAlert2 dialog.</p>',
    //     icon: 'info',
    //     confirmButtonText: 'OK'
    //   });


    const baseUrl = window.location.protocol + "//" + window.location.host + "/";
    let customerSurveyFiles = $('#customer_survey_files').val();
    let survey_id = $('#survey_id').val();
    if (customerSurveyFiles) {
        customerSurveyFiles = JSON.parse(customerSurveyFiles);
    }
    $.each(customerSurveyFiles, function(index, url) {
        let buildUrl = baseUrl + 'customer_survey_files/' + survey_id + '_' + url;
        const filename = buildUrl.split('/').pop();
        $('#customer_survey_area').append(
            $('<p>').addClass('card-text').append(
                $('<span>').text('Download Link: '),
                $('<a>').attr({
                    href: buildUrl,
                    target: '_blank'
                }).text(filename)
            )
        );
    });

    try {
        // scheduled_date
        var initialDate = $('#scheduled_date').val();
        if (initialDate) {
            var picker = $('.format-picker-new-date').pickadate('picker');
            picker.set('select', new Date(initialDate));
        }


    } catch (err) {}


    try {
        var schedules = $('#other_schedules').val();
        if (schedules) {
            schedules = JSON.parse(schedules);
        }
        // Loop through the schedules data and append them to the 'booked_schedule_area' element
        schedules.forEach(function(schedule) {
            var scheduleTitle = schedule.schedule_title;
            var date = schedule.date;

            var requested_amount = '';
            var payment_url = '';
            if (schedule.hasOwnProperty('requested_amount')) {
                requested_amount = schedule.requested_amount;
            }
            if (schedule.hasOwnProperty('payment_url')) {
                payment_url = schedule.payment_url;
            }

            console.log(schedule)
            var scheduleLink = $('<a>')
                .addClass('schedule-link')
                .attr('href', '#')
                .text('View Schedule: ' + scheduleTitle + ' ' + date)
                .css('margin-bottom',
                    '0px !important') // Add this line to set margin-bottom to 0 with !important
                .on('click', function() {
                    showScheduleDialog(schedule);
                });


            $('#booked_schedule_area').append(
                $('<p>').addClass('card-text').append(scheduleLink)
            );
        });

        // Function to display the SweetAlert2 dialog with the schedule details
        function showScheduleDialog(schedule) {
            var scheduleTitle = schedule.schedule_title;
            var date = schedule.date;
            var endDate = schedule.end_date;
            var description = schedule.description;
            var requested_amount = '';
            var payment_url = '';
            if (schedule.hasOwnProperty('requested_amount')) {
                requested_amount = schedule.requested_amount;
            }
            if (schedule.hasOwnProperty('payment_url')) {
                payment_url = schedule.payment_url;
            }

            console.log(schedule)
            Swal.fire({
                title: 'Schedule Details',
                html: '<h2>' + scheduleTitle + '</h2>' +
                    '<p style="text-align: left; margin-bottom: 0px !important;">Date: ' + date + '</p>' +
                    '<p style="text-align: left;">End Date: ' + endDate + '</p>' +
                    '<p style="text-align: left;">Description: ' + description + '</p>' +
                    (requested_amount ? '<p style="text-align: left;">Requested Amount: ' + requested_amount +
                        '</p>' : '') +
                    (payment_url ? '<p style="text-align: left;">Payment URL: <a href="' + payment_url +
                        '" target="_blank">' + payment_url + '</a></p>' : ''),
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    } catch (error) {

    }
</script>
@endsection
