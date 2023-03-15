@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
@endsection

<style>
    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    .accordion:hover {
        background-color: #ccc;
    }

    .panel {
        padding: 0 18px;
        display: none;
        background-color: white;
        overflow: hidden;
    }
</style>
@section('content')
    <section id="basic-horizontal-layouts">
        <div class="row match-height">

            <div class="col-md-9 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $mode }} {{ $title }}</h4>
                    </div>
                    <div class="mt-1">
                        <center>
                            <h4 class="">{{ $edit->content_title ?? '' }}</h4>
                        </center>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            <form class="form form-horizontal" id="template-form" method="POST"
                                enctype="multipart/form-data"
                                action="{{ $mode == 'Update' ? route('content_management.update', $edit->id) : route('content_management.store') }}">
                                @csrf

                                <div class="form-body">



                                    <div class="col-12 ">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>Content Category</span>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" name="content_category"
                                                        id="content_category">
                                                        <option value="" {{ $mode == 'Update' ? '' : 'selected' }}
                                                            style="display:none;">Please Select ....</option>
                                                        @foreach ($static['cm_categories'] as $categories)
                                                            <option value="{{ $categories }}"
                                                                {{ $mode == 'Update' && $categories == $edit->content_category ? 'selected' : '' }}>
                                                                {{ strtoupper($categories) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="thumbnail_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Content Thumbnail </span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input 
                                                accept="image/*, image/webp, file/webp" 
                                                type="file" name="content_thumbnail" id="content_thumbnail"
                                                    class="form-control @error('content_thumbnail') is-invalid @enderror">

                                                @error('content_title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-4 offset-md-4">
                                            <img src="{{ @$static['image_init_url'] }}/images/contents/{{ $mode == 'Update' ? $edit->content_thumbnail : 'placeholder.webp' }}"
                                                width="150" height="150">

                                        </div>
                                    </div>
                                </div>


                                <div class="col-12" id="title_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Content Title</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="content_title" type="text"
                                                    class="form-control @error('content_title') is-invalid @enderror"
                                                    name="content_title" placeholder="Content Title"
                                                    value="{{ $mode == 'Update' ? $edit->content_title : old('content_title') }}">

                                                @error('content_title')
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
                                <div class="col-12" id="url_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>URL (separated by comma if multiple)</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="content_url" type="text"
                                                    class="form-control @error('content_url') is-invalid @enderror"
                                                    name="content_url" placeholder="Content URL"
                                                    value="{{ $mode == 'Update' ? $edit->content_url : old('content_url') }}">

                                                @error('content_url')
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

                                <div class="col-12" id="content_schedule_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Content Display Schedule</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input type="text" name="content_schedule" id="from"
                                                    class="filter_data form-control format-picker" id="cal-start-date from"
                                                    readonly placeholder="MM-DD-YYYY"
                                                    value="{{ $mode == 'Update' ? $edit->content_schedule : old('content_schedule') }}">

                                                @error('content_schedule')
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
                                <div class="col-12" id="end_display_time_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Content Display Time</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input type="text" name="content_time" id="from"
                                                    class="filter_data form-control timepick" id="timepick" readonly
                                                    placeholder=""
                                                    value="{{ $mode == 'Update' ? $edit->content_time : old('content_time') }}">

                                                @error('content_time')
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
                                <div class="col-12" id="start_time_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Start Time</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input type="text" name="content_start_time" id="from"
                                                    class="filter_data form-control timepick" id="timepick" readonly
                                                    placeholder=""
                                                    value="{{ $mode == 'Update' ? $edit->content_start_time : old('content_start_time') }}">

                                                @error('content_start_time')
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
                                <div class="col-12" id="end_time_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>End Time</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input type="text" name="content_end_time" id="from"
                                                    class="filter_data form-control timepick" id="timepick" readonly
                                                    placeholder=""
                                                    value="{{ $mode == 'Update' ? $edit->content_end_time : old('content_end_time') }}">

                                                @error('content_end_time')
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


                                <div class="col-12" id="tag_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Content Tags</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="content_tags" type="text"
                                                    class="form-control @error('content_tags') is-invalid @enderror"
                                                    name="content_tags" placeholder="Content Tags (separated by comma)"
                                                    value="{{ $mode == 'Update' ? $edit->content_tags : old('content_tags') }}">

                                                @error('content_tags')
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

                                <div class="col-12" id="location_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Content Location</span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input id="content_location" type="text"
                                                    class="form-control @error('content_location') is-invalid @enderror"
                                                    name="content_location" placeholder="Content URL"
                                                    value="{{ $mode == 'Update' ? $edit->content_location : old('content_location') }}">

                                                @error('content_location')
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

                                <div class="col-12" id="content_files_div">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <span>Content Files </span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative has-icon-left">
                                                <input type="file" name="onboard_content_files[]" id="onboard_content_files" multiple
                                                    class="form-control @error('onboard_content_files') is-invalid @enderror">

                                                @error('content_title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>

                                            </div>
                                        </div>
                                      

                                        @if ($mode == 'Update')
                                        <div class="col-md-3">
                                            <p style="text-align: center; display:block;">Preview:</p> 
                                        </div>

                                        <div id="onboard_content_file_displays"
                                            style="overflow-y: scroll; height: 120px; width: 150px;"
                                            class="row">
                                        </div>
                                        @endif

                                    </div>
                                    <input type="text" id="content_files" readonly
                                        name="content_files" hidden
                                        value="{{ $mode == 'Update' ? $edit->content_files : '' }}">
                                </div>



                                {{-- <div class="col-12" id="body_html_div">
                                    <div class="form-group row">
                                        <div class="col-12">Body
                                            @error('content_description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12" style="color: #2c2c2c;">
                                            <input type="hidden" name="content_description" id="content_description">
                                            <div id="editor" class="editor" style="min-height: 200px;">
                                                {!! $mode == 'Update' ? $edit->content_description : '' !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 mt-9" id="placeholder_div">
                                    &nbsp;
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                </div>
 --}}





                                <div class="col-12" id="sub_content_section_parent">
                                    <div class="accordion">Sub Content Section</div>
                                    <div class="panel">
                                        <div class="col-12" id="body_html_div">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    @error('sub_content_section')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-12" style="color: #2c2c2c;">
                                                    <input type="hidden" name="sub_content_section"
                                                        id="sub_content_section">
                                                    <div id="sub_content_section" class="sub_content_section"
                                                        style="min-height: 200px;">
                                                        {!! $mode == 'Update' ? $edit->sub_content_section : '' !!}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-12 mt-9" id="placeholder_div">
                                            &nbsp;
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-12" id="content_description_section_parent">
                                    <div class="accordion">Content Description Section</div>
                                    <div class="panel">
                                        <div class="col-12" id="body_html_div">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    @error('content_description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-12" style="color: #2c2c2c;">
                                                    <input type="hidden" name="content_description"
                                                        id="content_description">
                                                    <div id="content_description_section"
                                                        class="content_description_section" style="min-height: 200px;">
                                                        {!! $mode == 'Update' ? $edit->content_description : '' !!}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-12 mt-9" id="placeholder_div">
                                            &nbsp;
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                        </div>


                                    </div>
                                </div>
                                <div>


                                    <div class="col-12" id="content_invitation_section_parent">
                                        <div class="accordion">Content Invitation Section</div>
                                        <div class="panel">
                                            <div class="col-12" id="body_html_div">
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        @error('content_description')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-12" style="color: #2c2c2c;">
                                                        <input type="hidden" name="content_invitation"
                                                            id="content_invitation">
                                                        <div id="content_invitation_section"
                                                            class="content_invitation_section" style="min-height: 200px;">
                                                            {!! $mode == 'Update' ? $edit->content_invitation : '' !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-12 mt-9" id="placeholder_div">
                                                &nbsp;
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                            </div>


                                        </div>
                                    </div>
                                    <div>



                                        <div class="col-12" id="content_footer_section_parent">
                                            <div class="accordion">Content Footer Section</div>
                                            <div class="panel">
                                                <div class="col-12" id="body_html_div">
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            @error('content_footer')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-12" style="color: #2c2c2c;">
                                                            <input type="hidden" name="content_footer"
                                                                id="content_footer">
                                                            <div id="content_footer_section"
                                                                class="content_footer_section" style="min-height: 200px;">
                                                                {!! $mode == 'Update' ? $edit->content_footer: '' !!}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-12 mt-9" id="placeholder_div">
                                                    &nbsp;
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                </div>


                                            </div>
                                        </div>



                                        <div class="col-12" hidden>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Content Images</span>

                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <input type="file" name="onboard_content_image[]"
                                                            id="onboard_content_image"
                                                            class="form-control @error('content_images') is-invalid @enderror"
                                                            multiple>
                                                    </div>

                                                    <input type="text" id="content_images" readonly
                                                        name="content_images"
                                                        value="{{ $mode == 'Update' ? $edit->content_images : '' }}">
                                                    @error('content_images')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror

                                                    @if ($mode == 'Update')
                                                        <p style="text-align: center;">Preview:</p>
                                                        <div id="onboard_content_image_displays"
                                                            style="overflow-y: scroll; height: 120px; width: 330px;"
                                                            class="row">
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>


                                        </div>


                                        <div class="col-12 pt-2">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Status</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>

                                                        <select
                                                            class="form-control @error('content_status') is-invalid @enderror"
                                                            name="content_status">
                                                            <option value="1"
                                                                {{ $mode == 'Update' && $edit->content_status == '1' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="0"
                                                                {{ $mode == 'Update' && $edit->content_status == '0' ? 'selected' : '' }}>
                                                                Inactive</option>
                                                        </select>

                                                        @error('content_status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12 pt-2" id="is_live_section_parent">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <span>Is Live</span>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative has-icon-left">
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>

                                                        <select
                                                            class="form-control @error('is_live') is-invalid @enderror"
                                                            name="is_live">
                                                            <option value="1"
                                                                {{ $mode == 'Update' && $edit->is_live == '1' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="0"
                                                                {{ $mode == 'Update' && $edit->is_live == '0' ? 'selected' : '' }}>
                                                                Inactive</option>
                                                        </select>

                                                        @error('is_live')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal fade" id="temppreview" tabindex="-1" role="dialog"
                                        aria-labelledby="temp_preview" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body temp_preview">
                                                    {{-- PREVIEW --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id"
                                        value="{{ $mode == 'Update' ? $edit->id : '' }}" id="edit_id">


                                    @if ($mode == 'Update')
                                        @method('PUT')
                                    @endif

                                    <div class="offset-md-2">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-primary mr-1 mb-1">Reset</button>

                                        <a href="{{ route('content_management.index') }}"
                                            class="btn btn-primary mr-1 mb-1">Back</a>
                                        <!-- <button type="button" class="btn btn-primary mr-1 mb-1"
                                                                                id="temp_preview">Preview</button> -->
                                    </div>

                                </div>

                            </form>
                            <div>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection


@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

@endsection





@section('page-script')
    <script src="{{ asset(mix('js/scripts/pickers/dateTime/pick-a-datetime.js')) }}"></script>

    <link href="{{ asset('vendors/css/editors/quill/quill.snow.css') }}" rel="stylesheet">
    <script src="{{ asset('vendors/js/editors/quill/quill.js') }}"></script>

    <script>
        $('.timepick').pickatime()
        $(document).ready(function() {

            $('#temp_preview').on('click', function() {
                template_preview();
            });

    
            const toolbarOptions = [
                [{
                    'size': ['small', false, 'large', 'huge']
                }], // custom dropdown
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                ['blockquote', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }], // outdent/indent
                [{
                    'align': []
                }],
                ['link']
            ];








            window._quill = new Quill('.sub_content_section', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                }
            });
            window._quill = new Quill('.content_description_section', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                }
            });
            window._quill = new Quill('.content_invitation_section', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                }
            });
            window._quill = new Quill('.content_footer_section', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                }
            });


            // assign body on submit:
            $('#template-form').on('submit', function() {
                var html1 = $('.ql-editor')[0].innerHTML;
                var html2 = $('.ql-editor')[1].innerHTML;
                var html3 = $('.ql-editor')[2].innerHTML;
                var html4 = $('.ql-editor')[3].innerHTML;
                $('#sub_content_section').val(html1);
                $('#content_description').val(html2);
                $('#content_invitation').val(html3);
                $('#content_footer').val(html4);
            })
        })

        var json_arr = {};
        json_arr["content_schedule"] = {
            sort_by: "descending"
        }

        var json_string = JSON.stringify(json_arr);
        console.log(json_string)

        // Image upload
        $(document).ready(function() {

            var content_images = document.getElementById('content_images');
            try {
                var content_images_lists = JSON.parse(content_images.value);
                console.log(content_images_lists)
                for (var i = content_images_lists.length - 1; i >= 0; i--) {
                    if (content_images_lists[i]) {
                        display_images(content_images_lists[i])
                    }
                }
            } catch (error) {

            }



            function display_images(image) {
                var new_div = document.createElement("div");
                var onboard_content_image_displays = document.getElementById('onboard_content_image_displays');
                var new_img = document.createElement("img");
                new_img.src = "/images/contents/" + image + "";
                new_img.id = image;
                new_img.title = "Click to remove";
                new_img.style.height = '100px';
                new_img.style.width = '100px';
                new_img.onclick = function() {
                    var delete_index = content_images_lists.indexOf(this.id)
                    delete content_images_lists[delete_index]
                    document.getElementById('content_images').value = content_images_lists.join();
                    console.log(content_images_lists)
                    console.log(content_images_lists.join())

                    this.remove()
                }
                onboard_content_image_displays.append(new_img);
            }

        });

        // Image upload


        // Dropdown hide/show
        let content_category = $('#content_category');
        let content_thumbnail = $('#thumbnail_div');
        let content_title = $('#title_div');
        let content_url = $('#url_div');
        let content_schedule_div = $('#content_schedule_div');
        let end_display_time = $('#end_display_time_div');
        let start_display_time = $('#start_time_div');
        let end_time_div = $('#end_time_div');
        let content_tag = $('#tag_div');
        let content_location = $('#location_div');
        let body_html_div = $('#body_html_div');
        let placeholder_div = $('#placeholder_div');
        let is_live_section_parent = $('#is_live_section_parent');

        let sub_content_section = $('#sub_content_section_parent');
        let content_description_section = $('#content_description_section_parent');
        let content_invitation_section = $('#content_invitation_section_parent');
        let content_footer_section = $('#content_footer_section_parent');
        let content_files_section = $('#content_files_div');
        function restart() {
            content_thumbnail.hide();
            content_title.hide();
            content_url.hide();
            end_display_time.hide();
            start_display_time.hide();
            end_time_div.hide();
            content_location.hide();
            content_tag.hide();
            body_html_div.hide();
            sub_content_section.hide();
            content_description_section.hide();
            content_invitation_section.hide();
            content_footer_section.hide();
            content_files_section.hide();
            content_schedule_div.hide();
            is_live_section_parent.hide();
        }

        // thumbnail_div
        // title_div
        // url_div
        // end_display_time_div
        // start_time_div
        // end_time_div
        // tag_div
        // location_div
        function check_category(key) {
            restart();
            switch (key) {
                case "visit":
                    content_thumbnail.show();
                    content_title.show();
                    content_url.show();
                    end_time_div.show();
                    start_display_time.show();
                    content_tag.show();
                    content_location.show();
                break;
                case "ministry":
                    body_html_div.hide().show();
                    content_thumbnail.show();
                    content_title.show();
                    content_tag.show();
                    sub_content_section.show();
                    content_description_section.show();
                    content_invitation_section.show();
                    content_footer_section.show();
                break;
                case "newsletter":
                    content_thumbnail.show();
                    content_title.show();
                    content_tag.show();
                    content_description_section.show();
                    content_files_section.show();
                break;
                case "event":
                    content_thumbnail.show();
                    content_title.show();
                    content_url.show();
                    content_schedule_div.show();
                    start_display_time.show();
                    end_time_div.show();
                    content_tag.show();
                    content_location.show();
                    content_description_section.show();
                break;
                case "sermon":
                    content_thumbnail.show();
                    content_title.show();
                    content_url.show();
                    content_schedule_div.show();
                    content_tag.show();
                    is_live_section_parent.show();
                    content_files_section.show();
                break;
                case "testimonial":
                    content_title.show();
                    content_description_section.show();
                break;
                case "leadership":
                    content_thumbnail.show();
                    content_description_section.show();
                    content_title.show();
                break;
                case "resources":
                    content_title.show();
                    content_tag.show();
                    content_description_section.show();
                    content_files_section.show();
                break;
                case "sunday school":
                case "roots and wings":
                case "world bible college":
                    content_url.show();

                break;

                default:
                    restart();
                    break;
            }
        }

        check_category(content_category.val());

        $('#content_category').on('change', function() {
            restart();
            check_category(content_category.val());

        })

        if(content_category.val()){
            check_category(content_category.val());

        }

        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }


        function format_files(){
            let content_files = $('#content_files');
            let content_files_raw = content_files.val().split(',');
            if(content_files_raw){
                for (let index = 0; index < content_files_raw.length; index++) {
                    const element = content_files_raw[index];
                    if(element){
                        console.log(element)
                        display_files(element, content_files_raw)
                    }
                }
            }
        }
        format_files();


        function display_files(file, content_files_lists) {
                var new_div = document.createElement("div");
                var onboard_content_file_displays = document.getElementById('onboard_content_file_displays');
                var new_file = document.createElement("div");
                new_file.src = "/files/contents/" + file + "";
                new_file.id = file;
                new_file.title = "Click to remove";
                new_file.innerHTML  = file+' <strong style="color:red;">(x)</strong> ';
                new_file.classList = "col-md-12";
                // new_file.style.width = '100px';
                new_file.onclick = function() {
                    var delete_index = content_files_lists.indexOf(this.id)
                    delete content_files_lists[delete_index]
                    document.getElementById('content_files').value = content_files_lists.join();

                    // console.log(content_files_lists.join())

                    this.remove()
                }
                onboard_content_file_displays.append(new_file);
            }
    </script>

@endsection
