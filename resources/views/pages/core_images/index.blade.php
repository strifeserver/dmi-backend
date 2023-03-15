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
                  <span class="filter-btn2">1 - 20 of</span> <span id="rowcount"></span>
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


            {{-- Modal --}}
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

                    <button type="button" class="btn btn-primary" data-dismiss="modal">Delete</button>
                  </div>
                </div>
              </div>
            </div>
<!-- // Basic example section end -->


@endsection
@section('vendor-script')
{{-- vendor files --}}
        <script src="{{ asset(mix('vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js')) }}"></script>
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
  /*** GET TABLE DATA FROM URL ***/

  var grid_data = <?=$agrid_data?>;
  document.getElementById('rowcount').innerHTML = grid_data.rows.length;
columnDefs =
    { headerName: 'Controls',field: 'id', width: 100, pinned:'left',
        cellRenderer: function(pa) {
          var url = '';
          url = url.replace(':id', pa.value);

          var url2 = '';
          url2 = url2.replace(':id', pa.value);

          var url4 = '';
          url4 = url4.replace(':id', pa.value);

          var eDiv = document.createElement('div');
          eDiv.innerHTML = '';
          if(controls.edit){
            eDiv.innerHTML+='<button data-id="'+pa.value+'" title="Edit" class="btn btn-icon btn-primary btn-simple update_btn"><i class="feather icon-edit"></i></button>&nbsp;';
          }
          if(controls.delete){
           eDiv.innerHTML+='<button data-id="'+pa.value+'" title="Delete" class="btn btn-icon btn-danger btn-simple delete_btn" data-toggle="modal" data-target="#modal"><i class="feather icon-trash-2"></i></button>&nbsp;';
          }

          var deletebtn = eDiv.querySelectorAll('.delete_btn')[0];
          var updatebtn = eDiv.querySelectorAll('.update_btn')[0];


          deletebtn.addEventListener('click', function() {
              var data_id = $(this).data("id");
                var url = '';
                url = url.replace(':id', data_id);
                document.getElementById("delform").action = url;
                document.getElementById("modal_msg").innerHTML = 'Are you sure you want to delete?';
          });

          updatebtn.addEventListener('click', function() {
            window.location.href = url;
          });


          return eDiv;
        }
    }


  if(controls.edit || controls.delete){
    // grid_data.column.push(columnDefs)
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
          gridOptions.api.sizeColumnsToFit();
      },
      onFilterModified: function(event){
         document.getElementById('rowcount').innerHTML = gridOptions.api.getDisplayedRowCount();
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
    $(".filter-btn2").text("1 - " + $this.text() + " of");
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





});





</script>

@endsection

