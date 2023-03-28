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
                                action="{{ $mode == 'Update' ? route('surveys.update', $edit->id) : route('surveys.store') }}">
                                @csrf

                                <input id="survey_pricing_details" type="text" readonly
                                    class="form-control @error('survey_pricing_details') is-invalid @enderror"
                                    name="survey_pricing_details"
                                    value="{{ $mode == 'Update' ? $edit->survey_pricing_details : old('survey_pricing_details') }}"
                                    autocomplete="survey_pricing_details" autofocus hidden>

                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Survey ID</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input id="survey_id" type="text" readonly
                                                            class="form-control @error('survey_id') is-invalid @enderror"
                                                            name="survey_id"
                                                            value="{{ $mode == 'Update' ? $edit->survey_id : old('survey_id') }}"
                                                            autocomplete="survey_id" autofocus>
                                                        @error('survey_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
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
                                                    <span>Client Name</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input id="survey_id" type="text" readonly
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name"
                                                            value="{{ $mode == 'Update' ? $edit->name : old('name') }}"
                                                            autocomplete="name" autofocus>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
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
                                                    <span>Client Email Address</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input id="email_address" type="text"
                                                            class="form-control @error('email_address') is-invalid @enderror"
                                                            name="email_address"
                                                            value="{{ $mode == 'Update' ? $edit->email_address : old('email_address') }}"
                                                            autocomplete="email_address" autofocus>
                                                        @error('email_address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
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
                                                    <span>Client Mobile Number</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input id="mobile_number" type="text"
                                                            class="form-control @error('mobile_number') is-invalid @enderror"
                                                            name="mobile_number"
                                                            value="{{ $mode == 'Update' ? $edit->mobile_number : old('mobile_number') }}"
                                                            autocomplete="mobile_number" autofocus>
                                                        @error('mobile_number')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
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
                                                    <span>Schedule</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">

                                                        <input id="schedule_info" readonly type="text"
                                                            class="form-control @error('schedule_info') is-invalid @enderror"
                                                            name="schedule_info"
                                                            value="{{ $mode == 'Update' ? @$edit->schedule_info : old('schedule_info') }}"
                                                            autocomplete="schedule_info" autofocus>
                                                        @error('schedule_info')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
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
                                                    <span>Status</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">

                                                        <input id="status" type="text" readonly
                                                            class="form-control @error('status') is-invalid @enderror"
                                                            name="status"
                                                            value="{{ $mode == 'Update' ? @$edit->status : old('status') }}"
                                                            autocomplete="status" autofocus>
                                                        @error('status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
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

                                                        <input id="customer_survey_files" type="text" readonly
                                                            class="form-control @error('customer_survey_files') is-invalid @enderror"
                                                            name="customer_survey_files"
                                                            value="{{ $mode == 'Update' ? @$edit->customer_survey_files : old('customer_survey_files') }}"
                                                            autocomplete="customer_survey_files" autofocus>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- 
                                        <div class="col-12" >
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Pending Payment</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">

                                                        <input id="pending_payment" type="text"
                                                            class="form-control @error('pending_payment') is-invalid @enderror"
                                                            name="pending_payment"
                                                            value="{{ $mode == 'Update' ? @$edit->pending_payment : old('pending_payment') }}"
                                                            autocomplete="pending_payment" autofocus>
                                                        @error('pending_payment')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        @if ($mode == 'Update')
                                            @method('PUT')
                                            <input id="id" type="hidden" name="id"
                                                value="{{ $mode == 'Update' ? $edit->id : '' }}">
                                        @endif

                                    </div>
                                </div>

                                <div id="survey_result">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-5 offset-md-3">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Topographic</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input id="topographic" type="text" readonly
                                                            class="form-control" name="topographic" value="0.00"
                                                            autocomplete="topographic">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 offset-md-3">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Parcellary</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input id="parcellary" type="text" readonly
                                                            class="form-control" name="parcellary" value="0.00"
                                                            autocomplete="parcellary">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 offset-md-3">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Relocation</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input id="relocation" type="text" readonly
                                                            class="form-control" name="relocation" value="0.00"
                                                            autocomplete="relocation">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 offset-md-3">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Hydro</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input id="hydro" type="text" readonly
                                                            class="form-control" name="hydro" value="0.00"
                                                            autocomplete="hydro">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 offset-md-5">
                                            <div id="update_price" class="btn btn-primary mr-1 mb-1">Update Price</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div id="customer_survey_area"></div>
                                        </div>
                                    </div>

                                    <hr>

                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                                        </div>

                                        <div class="col-md-2">
                                            <div hidden id="create_payment" class="btn btn-primary mr-1 mb-1">Create
                                                Payment
                                            </div>
                                        </div>

                                        <div class="col-md-1 offset-md-8">
                                            <a href="{{ route('surveys.index') }}"
                                                class="btn btn-primary mr-1 mb-1">Back</a>
                                        </div>
                                    </div>
                                </div>

                            </form>




                        </div>
                    </div>
                </div>

                
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
                    url: "http://127.0.0.1:8000/transactions",
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






    const baseUrl = window.location.protocol + "//" + window.location.host + "/";
    let customerSurveyFiles = $('#customer_survey_files').val();
    let survey_id = $('#survey_id').val();
    if(customerSurveyFiles){
        customerSurveyFiles = JSON.parse(customerSurveyFiles);
    }
    $.each(customerSurveyFiles, function(index, url) {
        let buildUrl = baseUrl + 'customer_survey_files/'+survey_id+'_'+url;        
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




</script>
@endsection
