@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
        {{-- vendor css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
@endsection

@section('page-style')
         {{-- Page Css files --}}
         <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
         <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
@endsection

@section('content')
  <!-- Basic example section start -->
<section id="basic-examples">

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
                  1 - 20 of 500
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
                        <button type="button" class="btn btn-white px-2 py-75 dropdown-toggle waves-effect waves-light"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Actions
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item " href="{{@$add_link}}"><i class="feather icon-clipboard"></i> Create</a>
                          <a class="dropdown-item  ag-grid-export-btn" href="#"><i class="feather icon-download"></i> Export as CSV</a>
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
<!-- // Basic example section end -->


@endsection
@section('vendor-script')
{{-- vendor files --}}
        <script src="{{ asset(mix('vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js')) }}"></script>
@endsection


@section('page-script')
<script>
$(document).ready(function() {
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
  /*** GET TABLE DATA FROM URL ***/

  // agGrid
  //   .simpleHttpRequest({ url: "" })
  //   .then(function(data) {
      
      
  //     gridOptions.api.setColumnDefs(data.column);  ////set column dynamic
  //     gridOptions.api.setRowData(data.rows); ////set rows 
    
  //   });
var grid_data = <?=$agrid_data?>;
console.log(grid_data.column)


console.log(grid_data.column)
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
          gridOptions.api.sizeColumnsToFit();
      }
  };


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

  /*** SET OR REMOVE EMAIL AS PINNED DEPENDING ON DEVICE SIZE ***/

//   if ($(window).width() < 768) {
//     gridOptions.columnApi.setColumnPinned("email", null);
//   } else {
//     gridOptions.columnApi.setColumnPinned("email", "left");
//   }
//   $(window).on("resize", function() {
//     if ($(window).width() < 768) {
//       gridOptions.columnApi.setColumnPinned("email", null);
//     } else {
//       gridOptions.columnApi.setColumnPinned("email", "left");
//     }
//   });

// console.log(gridOptions.columnApi)


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
//  filter inside role
$("#accesslevel").on("change", function () {
  var accesslevel = $("#accesslevel").val();
  filterData("accesslevel", accesslevel)
});





});





</script>

@endsection

