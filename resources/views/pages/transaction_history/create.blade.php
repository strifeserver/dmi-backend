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
                                action="{{ $mode == 'Update' ? route('transaction_history.update', $edit->id) : route('transaction_history.store') }}">
                                @csrf



                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Survey ID</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="survey_id" type="text"
                                                    class="form-control @error('survey_id') is-invalid @enderror"
                                                    name="survey_id"
                                                    value="{{ $mode == 'Update' ? $edit->survey_id : old('survey_id') }}"
                                                    autocomplete="survey_id" autofocus readonly>
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
                                            <span>Requested Amount</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="position" type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="requested_amount"
                                                    value="{{ $mode == 'Update' ? $edit->requested_amount : old('requested_amount') }}"
                                                    autocomplete="requested_amount" autofocus readonly>
                                                @error('requested_amount')
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
                                                <input id="position" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="status"
                                                    value="{{ $mode == 'Update' ? $edit->status : old('status') }}"
                                                    autocomplete="status" autofocus readonly>
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

                                @if ($is_admin == true)
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div id="paystatus" class="btn btn-primary mr-1 mb-1">Update as Paid</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif




                                @if ($mode == 'Update')
                                    @method('PUT')
                                    <input id="id" type="hidden" name="id"
                                        value="{{ $mode == 'Update' ? $edit->id : '' }}">
                                @endif

                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-1">
                                {{-- <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button> --}}
                            </div>



                            <div class="col-md-1 offset-md-8">
                                <a id="backtransactionhistory" href="{{ route('transaction_history.index') }}"
                                    class="btn btn-primary mr-1 mb-1">Back</a>
                                <a id="backtransactions" href="{{ route('transactions.index') }}"
                                    class="btn btn-primary mr-1 mb-1">Back</a>

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
    $(document).ready(function() {
        $("#backtransactionhistory").hide();
        $("#backtransactions").hide();
        var currentUrl = window.location.href;
        var currentUrl = currentUrl.split('/');
        const urlpath = currentUrl[3]
        console.log(urlpath);
        if (urlpath == 'transactions') {
            $("#backtransactions").show();
        } else {
            $("#backtransactionhistory").show();
        }




        // Add a click event handler to the #paystatus button
        $("#paystatus").click(function() {
            // Get the values of id and survey_id inputs
            var id = $("#id").val();
            var surveyId = $("#survey_id").val();

            // Create a data object with the id and survey_id
            var data = {
                id: id,
                survey_id: surveyId
            };
            var token = $("meta[name='csrf-token']").attr("content");
            // Send a POST request using AJAX
            $.ajax({
                url: "/api/update_survey?hash=" + encodeString(csrfToken)
                ",
                type: "POST",
                data: {
                    '_token': token,
                    id: id,
                    survey_id: surveyId
                },
                success: function(response) {
                    location.reload();
                },
                error: function(response) {}
            });
        });


        function encodeString(input) {
            // Convert the input string to Base64
            const encoded = btoa(input);
            return encoded;
        }

    });
</script>
@endsection
