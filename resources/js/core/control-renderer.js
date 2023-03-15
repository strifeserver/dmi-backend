class RowControlsRenderer
{
  /**
   * config: {}
   * controls: {
   *   edit|delete: bool
   * }
   *
   */
  init(params)
  {
    this.root = $()
  }

  getGui()
  {
    return this.root;
  }
}


class TableWrapper
{
  constructor()
  {
    this.gridOptions = {
      columnDefs: [],
      rowData: [],

      rowSelection: "single",
            // enableFilter: true,
        floatingFilter: true,
        suppressCellSelection: true,
        pagination: true,
        paginationPageSize: 20,
        rowModelType: 'infinite', // enable infinite row model
        cacheBlockSize: 50
    };
  }

  init(config)
  {
    this.gridOptions.columnDefs = config.columns;
    this.grid = new agGrid.Grid(config.grid, this.gridOptions);

    this.gridOptions.api.setDatasource(this.createDataSource());
    this.gridOptions.api.sizeColumnsToFit();
  }

  /**
   * Fetch row block
   */
  fetchBlock(config)
  {
    var params = [
      'start=' + config.startRow, // index
      'end=' + config.endRow
    ];

    if(Object.keys(config.filterModel).length)
      params.push('filter=' + encodeURIComponent(JSON.stringify(config.filterModel)));

    if(config.sortModel.length)
      params.push('sort=' + encodeURIComponent(JSON.stringify(config.sortModel)));

    console.log(params.join('&'));

    return fetch('/paginate/api_logs?' + params.join('&'))
      .then(data =>  data.json())
  }

  createDataSource()
  {
    var instance = {
      getRows: (params) => {

        this.fetchPage(params)
          .then((data) => {
            params.successCallback(data.result, data.max);
          })
      }
    }

    return instance;
  }
}

export { AgControlCell, TableWrapper };
