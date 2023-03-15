  
$(document).ready(function() {


    /*** DEFINED TABLE VARIABLE ***/
    var gridTable = document.getElementById("myGrid");
    var controls = __static.controls;
    var _data_filters = __static.data_filters;
    /*** GET TABLE DATA FROM URL ***/
    var grid_data = JSON.parse(__static.agrid_data)
    var page = __static.page; 
    var controls_btn_index = __static.controls_btn_index; 
    var table_version = __static.table_version; 
    // V1 TABLE
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
          
          edit_url = url.replace(':id', pa.value);
          edit_url = url.replace('general_settings', page)+'/edit';

          const reformat_url = edit_url.split('/');
          reformat_url[4] = pa.value;
          const reformatted_url = reformat_url.join('/')
          var eDiv = document.createElement('div');
          eDiv.innerHTML = '';
          if(controls.edit){
            eDiv.innerHTML+='<button data-id="'+pa.value+'" title="Edit '+pa.value+'" class="btn btn-icon btn-primary btn-simple update_btn"><i class="feather icon-edit"></i></button>&nbsp;';
          }
          if(controls.delete){  
           eDiv.innerHTML+='<button data-id="'+pa.value+'" title="Delete" class="btn btn-icon btn-danger btn-simple delete_btn" data-toggle="modal" data-target="#modal"><i class="feather icon-trash-2"></i></button>&nbsp;';
          }
          if(controls.edit){
            var updatebtn = eDiv.querySelectorAll('.update_btn')[0];
            updatebtn.addEventListener('click', function() {
            window.location.href = reformatted_url;
            });
          }
          if(controls.delete){
            var deletebtn = eDiv.querySelectorAll('.delete_btn')[0];
            deletebtn.addEventListener('click', function() {
                var data_id = $(this).data("id"); 
                  delete_url = url.replace(':id', data_id);
                  delete_url = url.replace('general_settings', page);
                  document.getElementById("delform").action = delete_url;
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
          autoSizeAll(true);
          // gridOptions.api.sizeColumnsToFit();
          gridOptions.columnApi.moveColumnByIndex(controls_btn_index, 0);
      },
      onFilterModified: function(event){
         document.getElementById('rowcount').innerHTML = gridOptions.api.getDisplayedRowCount();
      }
  };
  

    gridOptions['columnDefs'] = grid_data.column;
    gridOptions['rowData'] = grid_data.rows;


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
    
    const export_array = gridOptions.columnDefs.filter(x => x.field !== 'id');
    const today = new Date().toLocaleDateString("en-Us");
    var excelParams = {
        columnKeys: export_array.map(x => x.field),
        allColumns: false,
        fileName: __static.title+ today + '.csv',
        skipHeader: false
    }
    gridOptions.api.exportDataAsCsv(excelParams);
  });
// EXPORT

var token = $("meta[name='csrf-token']").attr("content");
            $('#filterClick').click(function() {
                var page = $('#page').val()
                // NEW ROUTE REQUIRED
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
                        if(js_debug_mode == true){
                          console.log('============')
                          console.log('Filter Submit Result Start:')
                          console.log(response)
                          console.log('============')
                        }
                        try {
                          var x = JSON.parse(response)
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


  // V1 TABLE





// //   /*** INIT TABLE ***/
new agGrid.Grid(gridTable, gridOptions);



});




