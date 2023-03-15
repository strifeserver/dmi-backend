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


  <!-- users filter start -->
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
              <div class="col-12 col-sm-6 col-lg-3">
                <label for="users-list-role">Role</label>
                <fieldset class="form-group">
                  <select class="form-control" id="accesslevel">
                    <option value="">All</option>
                    <option value="Core">Core</option>
                    <option value="User">User</option>
                  </select>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- users filter end -->




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


/*** DEFINED TABLE VARIABLE ***/
var gridTable = document.getElementById("myGrid");
var controls = __static.controls;
var _data_filters = <?=json_encode($data_filters)?>;
/*** GET TABLE DATA FROM URL ***/
var grid_data = <?=$agrid_data?>;
var page = "<?=$page?>";
var controls_btn_index = "<?=$controls_btn_index?>";
var table_version = __static.table_version; 



// V1 TABLE
if(table_version == 'v1'){
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


document.getElementById('rowcount').innerHTML = grid_data.rows.length;
columnDefs = 
{ headerName: 'Controls',field: 'id', width: 130,
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

}
var gridOptions = {
  rowSelection: "multiple",
  floatingFilter: true,
  filter: true,
  pagination: true,
  paginationPageSize: 10,
  pivotPanelShow: "always",
  colResizeDefault: "shift",
  animateRows: true,
  resizable: true,
  onGridReady: function () {
    if(table_version == 'v1'){
      autoSizeAll(true);
      gridOptions.api.sizeColumnsToFit();
      gridOptions.columnApi.moveColumnByIndex(controls_btn_index, 0);
    }
  },
  onFilterModified: function(event){
     document.getElementById('rowcount').innerHTML = gridOptions.api.getDisplayedRowCount();
  }
};

if(table_version == 'v1'){
gridOptions['columnDefs'] = grid_data.column;
gridOptions['rowData'] = grid_data.rows;
}


function autoSizeAll(skipHeader) {
  var allColumnIds = [];
  gridOptions.columnApi.getAllColumns().forEach(function(column) {
    allColumnIds.push(column.colId);
  });
  gridOptions.columnApi.autoSizeColumns(allColumnIds, skipHeader);

}

//   /*** FILTER TABLE ***/
function updateSearchQuery(val) {
gridOptions.api.setQuickFilter(val);
}

$(".ag-grid-filter").on("keyup", function() {
updateSearchQuery($(this).val());
});

//   /*** CHANGE DATA PER PAGE ***/
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
const export_array = _grid.gridOptions.columnDefs.filter(x => x.field !== 'id');
const today = new Date().toLocaleDateString("en-Us");
var excelParams = {
    columnKeys: export_array.map(x => x.field),
    allColumns: false,
    fileName: '{{$title}}_'+ today + '.csv',
    skipHeader: false
}
_grid.gridOptions.api.exportDataAsCsv(excelParams);
});
// EXPORT

var token = $("meta[name='csrf-token']").attr("content");
        $('#filterClick').click(function() {
            var page = $('#page').val()
            $.ajax({
                url: 'filter_'+page,
                type: "POST",
                data: {
                    '_token': token,
                    from: $('input[name="from"]').val(),
                    to: $('input[name="to"]').val(),
                    sku_id: $('input[name="sku_id"]').val(),
                },
                success: function(response) { // What to do if we succeed
                    try {
                      var x = JSON.parse(response)
                      // console.log(x)
                      // document.getElementById('rowcount').innerHTML = x.rowcount;
                      gridOptions.api.setRowData(x.rows);
                    }
                    catch(err) {
                      console.log('error result')
                    }
                },
                error: function(response) {
                }
            });
        });
        var headers_raw = $('.ag-header-cell-text');
        for (let index = 0; index < headers_raw.length; index++) {
            const element = headers_raw[index];
            var htms = $(element).html();
            var html_splitted = htms.split('_');
            var joint_html = html_splitted.join('<span style="opacity: 0">_<span/>');
            $(element).html(joint_html);
        }


//  FILTER MODEL       





// V1 TABLE


// V2 TABLE

if(table_version == 'v2'){

function makeControls() {
return {
    headerName: 'Controls',
    field: 'id',
    width: 250,
    cellRendererParams: {
        routes: {
            edit: __static.routes['audit_trail_logs.edit'],
            delete: __static.routes['audit_trail_logs.destroy'],
        },
        controls: __static.controls
    },
    cellRenderer: function (params) {
        if(!params.data) return // Not fully loaded yet
        const url = params.routes.edit.replace(':id', params.value)
        const root = document.createElement('div')
        const access = params.controls
        if(access.edit) {
            root.appendChild(CORE_Framework.createEdit({ href: url }))
        }

        if(access.delete) {
            const deleteBtn = CORE_Framework.createDelete({ id: params.value })

            deleteBtn.addEventListener('click', () => {
                document.getElementById("delform").action = params.routes.delete.replace(':id', params.value);
                document.getElementById("modal_msg").innerHTML = 'Are you sure you want to delete?';
            });

            root.appendChild(deleteBtn)
        }

        return root;
    }
};
}

document.getElementById("actions").style.display = "none"

const onDataLoaded = (count) => {
// console.log(Math.ceil(count / 20))
// document.getElementById('rowcount').innerHTML = Math.ceil(count / 20) || '(N/A)'
document.getElementById('rowcount').innerHTML = count
}

//
// V2: Pagination, /js/tables_v2.js
//
const gOptions = CORE_Framework.createGridConfig(
[ ...[makeControls()], ...(__static.columns) ], // merge
)

window._grid = new agGrid.Grid(document.querySelector('#myGrid'), gOptions)

_grid.gridOptions.api.setDatasource(
    CORE_Framework.createDataSource(__static.pagination_link,
    onDataLoaded)
)
_grid.gridOptions.api.sizeColumnsToFit();

var controls = __static.controls;

if (controls.add || controls.export) {
document.getElementById("actions").style.display = "block";
}



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
const getFilterState = function() {
return {
  from: CORE_Framework.canonicalDate(new Date($('#from').val()) ?? null),
  to: CORE_Framework.canonicalDate(new Date($('#to').val()) ?? null)
}
}
$('#filterClick').click(function(){
const filters = getFilterState()
const currentModel = gOptions.api.getFilterModel() || {}

let mergedModel = CORE_Framework.mergeFilterModel(['id'], filters, currentModel)


mergedModel.created_at = {
  filterType: 'text',
  type: 'contains', // custom
  filter: filters.from + ' to ' + filters.to,
}

gOptions.api.setFilterModel(mergedModel)
});
}




// //   /*** INIT TABLE ***/
new agGrid.Grid(gridTable, gridOptions);



});


</script>

@endsection

