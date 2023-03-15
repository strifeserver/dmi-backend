@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
        {{-- vendor css files --}}
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
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Filters</h4>
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
				@endforeach

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
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
                          <a class="dropdown-item " href="{{@$add_link}}"><i class="feather icon-clipboard"></i> Create</a>
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
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
@endsection

@section('page-script')
<script>
$(document).ready(function() {
  document.getElementById("actions").style.display = "none"; 
  /*** COLUMN DEFINE ***/
  var columnDefs = [];
  /*** GRID OPTIONS ***/
  var gridOptions = {
    columnDefs: columnDefs,
    rowSelection: "multiple",
    floatingFilter: true,
    filter: true,
    pagination: true,
    paginationPageSize: 20,
    pivotPanelShow: "always",
    colResizeDefault: "shift",
    animateRows: true,
    resizable: true
  };
  /*** DEFINED TABLE VARIABLE ***/
  var gridTable = document.getElementById("myGrid");
  var controls = <?=$controls?>;
  var _data_filters = <?=json_encode($data_filters)?>;
  /*** GET TABLE DATA FROM URL ***/
  var grid_data = <?=$agrid_data?>;
  var page = "<?=$page?>";
  var controls_btn_index = "<?=$controls_btn_index?>";


    document.getElementById('rowcount').innerHTML = grid_data.rows.length;
columnDefs = 
    { headerName: 'CONTROLS',field: 'id', width: 130,
        cellRenderer: function(pa) {
          var url = '{{ route("general_settings.edit", ":id") }}';
          url = url.replace(':id', pa.value);
          url = url.replace('general_settings', page);
          var eDiv = document.createElement('div');
          eDiv.innerHTML = '';
          if(controls.edit){
            eDiv.innerHTML+='<button data-id="'+pa.value+'" title="Edit" class="btn btn-icon btn-primary btn-simple update_btn"><i class="feather icon-edit"></i></button>&nbsp;';
          }
          if(controls.delete){  
           eDiv.innerHTML+='<button data-id="'+pa.value+'" title="Delete" class="btn btn-icon btn-danger btn-simple delete_btn" data-toggle="modal" data-target="#modal"><i class="feather icon-trash-2"></i></button>&nbsp;';

          }
          if(controls.edit){
            var updatebtn = eDiv.querySelectorAll('.update_btn')[0];
            updatebtn.addEventListener('click', function() {
              window.location.href = url;
            });
          }
          if(controls.delete){
            var deletebtn = eDiv.querySelectorAll('.delete_btn')[0];
            deletebtn.addEventListener('click', function() {
                var data_id = $(this).data("id"); 
                  var url = '{{ route("general_settings.destroy", ":id") }}';
                  url = url.replace(':id', data_id);
                  url = url.replace('general_settings', page);
                  document.getElementById("delform").action = url;
                  document.getElementById("modal_msg").innerHTML = 'Are you sure you want to delete?';
            });
          }
          eDiv.style.textAlign = "center"; 
          return eDiv;
        }
    }
  if(controls.edit || controls.delete){
    grid_data.column.push(columnDefs)
  }
  if(controls.add || controls.export){
    document.getElementById("actions").style.display = "block";
  }
  var gridOptions = {
      columnDefs: grid_data.column,
      rowData: grid_data.rows,
      rowSelection: "multiple",
      floatingFilter: true,
      filter: true,
      pagination: true,
      paginationPageSize: 20,
      pivotPanelShow: "always",
      colResizeDefault: "shift",
      animateRows: true,
      resizable: true,
      onGridReady: function () {
        //autoSizeAll(true);
          gridOptions.api.sizeColumnsToFit();
          gridOptions.columnApi.moveColumnByIndex(controls_btn_index, 0);
      },
      onFilterModified: function(event){
         document.getElementById('rowcount').innerHTML = gridOptions.api.getDisplayedRowCount();
      }
  };

  function autoSizeAll(skipHeader) {
      var allColumnIds = [];
      gridOptions.columnApi.getAllColumns().forEach(function(column) {
        allColumnIds.push(column.colId);
      });
      gridOptions.columnApi.autoSizeColumns(allColumnIds, skipHeader);

  }

  /*** FILTER TABLE ***/
  function updateSearchQuery(val) {
    gridOptions.api.setQuickFilter(val);
  }

  $(".ag-grid-filter").on("keyup", function() {
    updateSearchQuery($(this).val());
  });

  /*** CHANGE DATA PER PAGE ***/
  function changePageSize(value) {
    gridOptions.api.paginationSetPageSize(Number(value));
  }

  $(".sort-dropdown .dropdown-item").on("click", function() {
    var $this = $(this);
    changePageSize($this.text());
    $(".filter-btn").text("1 - " + $this.text() + " of 500");
  });

  /*** EXPORT AS CSV BTN ***/
  $(".ag-grid-export-btn").on("click", function(params) {
    gridOptions.api.exportDataAsCsv();
  });

  /*** INIT TABLE ***/
  new agGrid.Grid(gridTable, gridOptions);



 //  filter data function
    var filterData = function agSetColumnFilter(column, val) {
      var filter = gridOptions.api.getFilterInstance(column)
      var modelObj = null
      if (val !== "all") {
        modelObj = {
          type: "equals",
          filter: val
        }
      }
      filter.setModel(modelObj)
      gridOptions.api.onFilterChanged()
    }



// IMPORT
  var check_error = document.getElementById("error_active");
  if(check_error != null){
    setTimeout(function() {
      document.getElementById("download_errors").click();
    }, 1000);
  }
// IMPORT



// FILTER START
	$.each(_data_filters, function( i, val ){
		if(val.filter_type == 'dropdown_filter'){
			$( "#"+val.filter_code ).change(function() {
				var code = val.filter_code;
				var value = $(this).val();
			  	filterData(code, value)
			});
		}
	});
// FILTER END



// EXPORT
	$(".ag-grid-export-btn").on("click", function(params) {
	  var export_array = [];
	  $.each( grid_data.column, function( key, value ) {
	    if(value['field'] != 'id'){
	    	export_array.push(value['field']);
	    }
	  });
			var today  = new Date();
			var today  = today.toLocaleDateString("en-US");
	    var excelParams = {
	        columnKeys: export_array,
	        allColumns: false,
	        fileName: '{{$title}}_'+today+'.csv',
	        skipHeader: false
	    }
	    gridOptions.api.exportDataAsCsv(excelParams);
	});
// EXPORT

});



</script>

@endsection

