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

@section('content')

<style>
  .cell-wrap-text {
     white-space: normal !important;
   }
   .ag-cell
   {
     border-right-color: #EDEDED !important;
     border-right-width: 1px  !important;
     border-right-style: solid !important;
   }
   .ag-header-cell-label .ag-header-cell-text {
     white-space: normal !important;
   }
</style>
  <!-- Basic example section start -->
<section id="basic-examples">

<!--  FILTER start -->


@if($filter_count > 0)


  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Filters</h4>
      <input type="hidden" id="page" value={{$page}} readonly>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
          <form>
            <div class="row">
              @foreach ($data_filters as $data_filter)
                @if($data_filter['filter_type'] == 'dropdown_filter')
                  <div class="col-12 col-sm-6 col-lg-3">
                      <label for="users-list-role">{{$data_filter['filter_name']}}</label>
                      <fieldset class="form-group">
                        <select class="select2 form-control {{$data_filter['filter_code']}}" id="{{$data_filter['filter_code']}}" >
                          <option value="">All</option>
                          @foreach ($data_filter['dropdown_data'] as $dropdown_data)
                           <option value="{{$dropdown_data['status_name']}}">{{$dropdown_data['status_name']}}</option>
                          @endforeach
                        </select>
                      </fieldset>
                  </div>
                @endif
                @if($data_filter['filter_type'] == 'date_filter')
                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="users-list-role">Created Date From</label>
                    <fieldset class="form-group">
                        <input type="text" name="from" id="from" class="form-control format-picker"
                            id="cal-start-date from" readonly="" placeholder="MM-DD-YYYY">
                    </fieldset>
                </div>
        
                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="users-list-status">Created Date To:</label>
                    <fieldset class="form-group">
                        <input type="text" name="to" id="to" class="form-control format-picker" id="cal-start-date to"
                            readonly="" placeholder="MM-DD-YYYY">
                    </fieldset>
                </div>


                @endif
        @endforeach
        


            </div>
          </form>

            <div class="row">

            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary" id="filterClick">Search</button>
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>
@endif
<!--  FILTER end -->

<!-- IMPORT start -->
@if($is_import == true)
@can('import')
<div class="card">
  <div class="card-content collapse show">
    <div class="card-body">
        <div class="users-list-filter">
         <meta name="csrf-token" content="{!! csrf_token() !!}">
            <!-- IMPORT -->
            <h4 class="card-title">Import</h4>
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-4">
                <form class="form form-horizontal" enctype="multipart/form-data" method="POST" action="{{route('imports.store')}}">
                        @csrf
                        <input type="text"readonly name="import_mode" value="{{$page}}" hidden>
                  <p>Import {{$title}}</p>
                <fieldset class="form-group">
                  <label for="import_upload" class="btn btn-primary">
                       Import Template
                  </label>
                   <input id="import_upload" style="display:none;"  type="file" name="import_file">                 
                </fieldset>
                <button id="upload_btnn" class="btn btn-primary">Upload</button>
                </form>
              </div>
            </div>
            <!-- IMPORT -->
        </div>
    </div>
  </div>
</div>
@endcan
@endif
<!-- IMPORT end -->

  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            @if(session()->get('success'))
              <div class="alert alert-success">
                {{ session()->get('success') }}  
              </div><br />
            @endif

            <!-- IMPORT -->
            @can('import')
              @if(session()->get('error_comment'))
                  <div id="error_active" class="alert alert-danger">
                    {{ session()->get('error_comment') }}  
                    &nbsp;
                    &nbsp;
                    @if(session()->get('error_link'))
                    <a id="download_errors" href="{{ session()->get('error_link') }}  ">Click here if the file didn't download Automatically</a>
                    @endif
                  </div>
              @endif
            @endcan
            <!-- IMPORT -->


            <div
              class="ag-grid-btns d-flex justify-content-between flex-wrap mb-1">

              <div class="dropdown sort-dropdown mb-1 mb-sm-0">
                <button
                  class="btn btn-white filter-btn dropdown-toggle border text-dark"
                  type="button"
                  id="dropdownMenuButton6"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  1 - 20 of </span> <span id="rowcount"></span>
                </button>
                <div
                  class="dropdown-menu dropdown-menu-right"
                  aria-labelledby="dropdownMenuButton6"
                >
                  <a class="dropdown-item" href="#">20</a>
                  <a class="dropdown-item" href="#">50</a>
                  <a class="dropdown-item" href="#">100</a>
                  <a class="dropdown-item" href="#">150</a>
                </div>
              </div>
              <div class="ag-btns d-flex flex-wrap">
                <input
                  type="text"
                  class="ag-grid-filter form-control w-50 mr-1 mb-1 mb-sm-0"
                  id="filter-text-box"
                  placeholder="Search...."
                />
                <div class="action-btns">
                    <div class="btn-dropdown ">
                      <div class="btn-group dropdown actions-dropodown">
                        <button id="actions"type="button" class="btn btn-white px-2 py-75 dropdown-toggle waves-effect waves-light"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Actions
                        </button>
                        <div class="dropdown-menu">
                          @can('add')
                          <a class="dropdown-item " href="{{ route('email_template.create') }}"><i class="feather icon-clipboard"></i> Create</a>
                          @endcan
                          @can('export')
                          <a class="dropdown-item  ag-grid-export-btn" href="#"><i class="feather icon-download"></i> Export as CSV</a>
                          @endcan
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>

        <div id="myGrid" class="aggrid ag-theme-material"></div>
      </div>
    </div>
  </div>
</section>

@can('delete')
<div class="modal fade" id="modal" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
    role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal_msg"class="modal-body" style="color: black;">
      
      </div>
      <div class="modal-footer">
        <form id="delform" action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form> 

        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endcan


@endsection
@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset('js/tables_v2.js') }}"></script>

    <script>
        window.__static = @json($static)
    </script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/pickers/dateTime/pick-a-datetime.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/sweet-alerts.js')) }}"></script>

<script>

var js_debug_mode = true;
var table_version = __static.table_version; 
var table_version_file = __static.table_version_file; 
var head = document.getElementsByTagName('head')[0];
var js = document.createElement("script");

// js.type = "text/javascript";

if (table_version == 'v1' && table_version_file == 'default')
{
  var edit_url = '{{ route("email_template.edit", ":id") }}';
  var delete_url = '{{ route("email_template.destroy", ":id") }}';
    js.src = "{{ asset('js/scripts/table_js/table_v1.js') }}";
    
}
if (table_version == 'v2' && table_version_file == 'default')
{
    js.src = "{{ asset('js/scripts/table_js/table_v2.js') }}";
}
if (table_version_file == 'mixed')
{
  var edit_url = '{{ route("email_template.edit", ":id") }}';
  var delete_url = '{{ route("email_template.destroy", ":id") }}';
    js.src = "{{ asset('js/scripts/table_js/table_mixed.js') }}";
}

head.appendChild(js);



</script>
@endsection

