
$(document).ready(function () {


	/*** DEFINED TABLE VARIABLE ***/
	var gridTable = document.getElementById("myGrid");
	var controls = __static.controls;
	/*** GET TABLE DATA FROM URL ***/
	var page = __static.page;
	var table_version = __static.table_version;
	// V1 TABLE
  
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
  
	  },
	  onFilterModified: function (event) {
		document.getElementById('rowcount').innerHTML = gridOptions.api.getDisplayedRowCount();
	  }
	};
  
  
  
	//   /*** FILTER TABLE ***/
	function updateSearchQuery(val) {
	  gridOptions.api.setQuickFilter(val);
	}
  
	$(".ag-grid-filter").on("keyup", function () {
	  updateSearchQuery($(this).val());
	});
  
	//   /*** CHANGE DATA PER PAGE ***/
	function changePageSize(value) {
	  gridOptions.api.paginationSetPageSize(Number(value));
	}
  
	$(".sort-dropdown .dropdown-item").on("click", function () {
	  var $this = $(this);
	  changePageSize($this.text());
	  $(".filter-btn").text("1 - " + $this.text() + " of 500");
	});
  
	/*** EXPORT AS CSV BTN ***/
	$(".ag-grid-export-btn").on("click", function (params) {
	  gridOptions.api.exportDataAsCsv();
	});
  
  
	// IMPORT
	var check_error = document.getElementById("error_active");
	if (check_error != null) {
	  setTimeout(function () {
		document.getElementById("download_errors").click();
	  }, 1000);
	}
	// IMPORT
  
  
  
	// EXPORT
	$(".ag-grid-export-btn").on("click", function (params) {
	  const export_array = _grid.gridOptions.columnDefs.filter(x => x.field !== 'id');
	  const today = new Date().toLocaleDateString("en-Us");
	  var excelParams = {
		columnKeys: export_array.map(x => x.field),
		allColumns: false,
		fileName: __static.title + today + '.csv',
		skipHeader: false
	  }
	  _grid.gridOptions.api.exportDataAsCsv(excelParams);
	});
	// EXPORT
  
  
  
	// V2 TABLE
  
	if (table_version == 'v2') {
  
	  function makeControls() {
		return {
		  headerName: 'CONTROLS',
		  field: 'id',
		  cellRendererParams: {
			routes: {
			  edit: __static.routes[page + '.edit'],
			  delete: __static.routes[page + '.destroy'],
  
			},
			controls: __static.controls
		  },
		  minWidth: 250,
		  // maxWidth: 780,
		  // width: 780,
		  cellRenderer: function (params) {
			if (!params.data) return // Not fully loaded yet
			const url = params.routes.edit.replace(':id', params.value)
			const root = document.createElement('div')
			const access = params.controls
			if (access.edit) {
			  root.appendChild(CORE_Framework.createEdit({ href: url }))
			}
  
			if (access.delete) {
			  const deleteBtn = CORE_Framework.createDelete({ id: params.value })
  
			  deleteBtn.addEventListener('click', () => {
				document.getElementById("delform").action = params.routes.delete.replace(':id', params.value);
				document.getElementById("modal_msg").innerHTML = 'Are you sure you want to delete?';
			  });
  
			  root.appendChild(deleteBtn)
			}
  
  
			const tempBtn = CORE_Framework.createcustom_btn1({ id: params.value, button_title: 'Confirm', btn_type: 'btn-info', icon_class: 'fa fa-key' })
			tempBtn.addEventListener('click', () => {
			  document.getElementById("user_id").value = params.value
			  document.getElementById("custom_modal_title").innerHTML = 'Reset Password';
			  document.getElementById("custom_modal_content").innerHTML = 'Confirm Reset Password?';
  
			  const loading = /*html*/
				`<div class="spinner-grow text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<div class="spinner-grow text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<div class="spinner-grow text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>`
			  $('#custom_modal_content').html(loading);
			  const formData = new FormData()
			  Object.entries({
				_token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
				id: params.value,
			  }).forEach((value) => {
				formData.append(value[0], value[1])
			  })
  
			  fetch('/users/make_temp', {
				method: 'POST',
				body: formData
			  })
				.then(response => response.text())
				.then(content => {
				  document.getElementById('custom_modal_content').innerHTML = `<h1>${content}</h1`
				})
			});
			root.appendChild(tempBtn)
  
  
  
			const lockbtn = CORE_Framework.createcustom_btn1({ id: params.value, button_title: 'Confirm', btn_type: 'btn-success', icon_class: 'feather icon-lock' })
			lockbtn.addEventListener('click', () => {
			  document.getElementById("user_id").value = params.value
			  document.getElementById("custom_modal_title").innerHTML = 'Lock Account';
			  document.getElementById("custom_modal_content").innerHTML = 'Confirm Lock Account?';
  
			  const loading = /*html*/
				`<div class="spinner-grow text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<div class="spinner-grow text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<div class="spinner-grow text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>`
			  $('#custom_modal_content').html(loading);
			  const formData = new FormData()
			  Object.entries({
				_token: document.querySelector('meta[name=csrf-token]').getAttribute('content'),
				id: params.value,
			  }).forEach((value) => {
				formData.append(value[0], value[1])
			  })
  
			  fetch('/users/lock_account', {
				method: 'POST',
				body: formData
			  })
				.then(response => response.text())
				.then(content => {
				  const result = JSON.parse(content);
				  document.getElementById('custom_modal_content').innerHTML = `<h1>`+result.remarks+`</h1`
				})
			});
			root.appendChild(lockbtn)
  
  
			
  
  
  
  
  
  
  
  
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
		[...[makeControls()], ...(__static.columns)], // merge
	  )
	  if (controls.delete == false && controls.edit == false) {
		delete gOptions.columnDefs[0]
	  }
  
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
  
  
  
	  const getFilterState = function () {
  
		var filters = $('.filter_data');
		var recorded_filters = {};
		for (let index = 0; index < filters.length; index++) {
		  const element = filters[index];
		  const filter_names = $(element).attr('name');
		  // console.log($(element).attr('name'))
  
		  if (filter_names == 'to' || filter_names == 'from') {
			recorded_filters[filter_names] = CORE_Framework.canonicalDate(new Date($(element).val()) ?? null)
		  } else {
			recorded_filters[filter_names] = ($(element).val() ?? null)
		  }
		}
		return recorded_filters;
	  }
	  $('#filterClick').click(function () {
		const filters = getFilterState()
		const currentModel = gOptions.api.getFilterModel() || {}
		let mergedModel = CORE_Framework.mergeFilterModel(['id'], filters, currentModel)
  
		$.each(filters, function (i, val) {
		  var key_name = i;
  
		  if (key_name == 'from') {
			mergedModel.created_at = {
			  filterType: 'text',
			  type: 'contains', // custom
			  filter: filters.from + ' to ' + filters.to,
			}
		  } else if (key_name != 'to') {
			mergedModel[key_name] = {
			  filterType: 'text',
			  type: 'contains', // custom
			  filter: val,
			}
		  }
  
  
		});
		gOptions.api.setFilterModel(mergedModel)
	  });
	}
  
  
  
  
	// //   /*** INIT TABLE ***/
	new agGrid.Grid(gridTable, gridOptions);
  
  
  
  });
  
  
  
  
  