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
                                action="{{ $mode == 'Update' ? route('workers.update', $edit->id) : route('workers.store') }}">
                                @csrf



                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Worker Name</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="worker_name" type="text"
                                                    class="form-control @error('worker_name') is-invalid @enderror"
                                                    name="worker_name"
                                                    value="{{ $mode == 'Update' ? $edit->worker_name : old('worker_name') }}"
                                                    autocomplete="worker_name" autofocus>
                                                @error('worker_name')
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
                                            <span>Position</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="position" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="position"
                                                    value="{{ $mode == 'Update' ? $edit->position : old('position') }}"
                                                    autocomplete="position" autofocus>
                                                @error('position')
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
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                            </div>



                            <div class="col-md-1 offset-md-8">
                                <a href="{{ route('workers.index') }}" class="btn btn-primary mr-1 mb-1">Back</a>
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

@endsection
