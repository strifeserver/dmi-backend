@extends('layouts/contentLayoutMaster')

@section('title', '')

@section('vendor-style')
        {{-- vendor css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
         {{-- Page Css files --}}
         <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
         <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
@endsection

@section('content')



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


var table_version = __static.table_version;
var head = document.getElementsByTagName('head')[0];
var js = document.createElement("script");

// js.type = "text/javascript";

if (table_version == 'v1')
{
  var url = '{{ route("general_settings.edit", ":id") }}';
  var url = '{{ route("general_settings.destroy", ":id") }}';
    js.src = "{{ asset('js/scripts/table_js/table_v1.js') }}";
}
if (table_version == 'v2')
{
    js.src = "{{ asset('js/scripts/table_js/table_v2.js') }}";
}

head.appendChild(js);




</script>

@endsection
