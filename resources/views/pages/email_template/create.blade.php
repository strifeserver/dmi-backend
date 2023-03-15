@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $mode }} {{ $title }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            <form class="form form-horizontal" id="template-form" method="POST"
                                action="{{ $mode == 'Update' ? route('email_template.update', $edit->id) : route('email_template.store') }}">
                                @csrf

                                <div class="form-body">

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Subject</span>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="position-relative has-icon-left">
                                                    <input id="email_header" type="text"
                                                        class="form-control @error('email_header') is-invalid @enderror"
                                                        name="email_header" placeholder="Subject"
                                                        value="{{ $mode == 'Update' ? $edit->email_header : old('email_header') }}"
                                                        required>

                                                    @error('email_header')
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
                                            <div class="col-12">Body
                                                @error('email_body')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-12" style="color: #2c2c2c;">
                                                <input type="hidden" name="email_body" id="email_body">
                                                <div id="editor">
                                                    {!! $mode == 'Update' ? $edit->email_body : '' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <br>
                                        <br>
                                        <br>
                                    </div>



                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Status</span>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="position-relative has-icon-left">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>

                                                    <select class="form-control @error('sending') is-invalid @enderror"
                                                        name="status" required>
                                                        <option value="1"
                                                            {{ $mode == 'Update' && $edit->status == '1' ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="0"
                                                            {{ $mode == 'Update' && $edit->status == '0' ? 'selected' : '' }}>
                                                            Inactive</option>
                                                    </select>

                                                    @error('sending')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                @if ($mode == 'Update')
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $mode == 'Update' ? $edit->id : '' }}">
                                @endif

                                <div class="offset-md-2">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-primary mr-1 mb-1">Reset</button>

                                    <a href="{{ route('email_template.index') }}"
                                        class="btn btn-primary mr-1 mb-1">Back</a>
                                </div>

                        </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('page-script')

    <link href="{{ asset('vendors/css/editors/quill/quill.snow.css') }}" rel="stylesheet">
    <script src="{{ asset('vendors/js/editors/quill/quill.js') }}"></script>

    <script>
        $(document).ready(function() {

            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                ['blockquote', 'code-block'],

                [{
                    'header': 1
                }, {
                    'header': 2
                }], // custom button values
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }], // superscript/subscript
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }], // outdent/indent
                [{
                    'direction': 'rtl'
                }], // text direction

                [{
                    'size': ['small', false, 'large', 'huge']
                }], // custom dropdown
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],

                [{
                    'color': []
                }, {
                    'background': []
                }], // dropdown with defaults from theme
                [{
                    'font': []
                }],
                [{
                    'align': []
                }],

                ['clean'] // remove formatting button
            ];


            window._quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                },

            });

            // assign body on submit:
            $('#template-form').on('submit', function() {
                var html = $('.ql-editor')[0].innerHTML;
                $('#email_body').val(html);
            })
        })
    </script>

@endsection
