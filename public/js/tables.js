(function(window, $) {

  class RowControlsRenderer
  {
    static DEFAULT_CLASS = ' btn-icon'
    /**
     * config: {}
     * controls: {
     *   edit|delete: bool
     * }
     *
     */
    init(params)
    {
      this.root = $('<div>').attr('data-id', params.value)
      /*var group = $('<div>')*/.addClass('btn-group');

      for(var control of params.config) {
        if(control.type == 'link') {
          var e = $('<a>');

          e.attr('href', control.href.replace('{id}', params.value));
          e.attr('class', control.class + RowControlsRenderer.DEFAULT_CLASS);
          e.append(
            $('<i>').attr('class', control.icon)
          );

          this.addExtraAttr(e, control.attr);
          this.root.append(e);

        } else if(control.type == 'action') {
          var e = $('<button>');

          e.attr('data-id', params.value);
          e.attr('class', control.class + RowControlsRenderer.DEFAULT_CLASS);
          e.append(
            $('<i>').attr('class', control.icon)
          );

          this.addExtraAttr(e, control.attr);
          this.root.append(e);
        }
      }

      // this.root.append
    }

    addExtraAttr(e, attrs)
    {
      if(attrs) {
        Object.keys(attrs).forEach(k => {
          e.attr(k, attrs[k]);
        });
      }
    }

    getGui()
    {
      return this.root[0];
    }

    replaceId(subject, id)
    {
      return subject.replace('{id}', id);
    }
  }

  class TableWrapper
  {
    constructor(config, grid, source)
    {
      this.source = source;
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

      this.init(config, grid);
    }

    init(config, grid)
    {
      this.gridOptions.columnDefs = config.columns;
      this.grid = new agGrid.Grid(grid, this.gridOptions);

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

      return fetch(`/paginate/${this.source}?` + params.join('&'))
        .then(data =>  data.json())
    }

    createDataSource()
    {
      var instance = {
        getRows: (params) => {

          this.fetchBlock(params)
            .then((data) => {
              params.successCallback(data.result, data.max);
            })
        }
      }

      return instance;
    }
  }

  class CustomModal
  {

  }

  window.RowControlsRenderer = RowControlsRenderer;
  window.TableWrapper = TableWrapper;
  window.CustomModal = CustomModal;

})(window, jQuery);
