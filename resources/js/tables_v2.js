/**
* Note:  Requires ES6 support
*/
(function (_window) {
  const CORE_Framework = {};

  /**
  * Create agGrid data source
  * @param paginateUrl pagination endpoint (can be relative; do not include '?')
  * @see https://www.ag-grid.com/javascript-data-grid/infinite-scrolling/#datasource-interface
  */
  CORE_Framework.createDataSource = (paginateUrl, onDataLoaded) => {
    return {
      getRows: async (config) => {
        const query = [
          'start=' + config.startRow,
          'end=' + config.endRow
        ];

        if (Object.keys(config.filterModel).length)
          query.push('filter=' + encodeURIComponent(JSON.stringify(config.filterModel)));

        if (config.sortModel.length)
          query.push('sort=' + encodeURIComponent(JSON.stringify(config.sortModel)));

        await fetch(paginateUrl + '?' + query.join('&'))
          .then(data => data.json())
          .then(data => { config.successCallback(data.result, data.max); return data; })
          .then(data => { onDataLoaded && onDataLoaded(data.max, data.meta); })
          .catch(() => { config.failCallback(); });
      }
    };
  };

  /**
  * Create basic agGrid configuration
  */
   CORE_Framework.createGridConfig = (columnDefs, overrides) => {
    columnDefs[0]['width'] = 250;
    var GridOption = {
      columnDefs: columnDefs,
      // rowData: [], // Dynamic via infinite row model
      rowSelection: "single",
      rowHeight: 43,
      floatingFilter: true,
      suppressCellSelection: true,
      onGridReady: function () { // NOTE: Don't use arrow function here
        this.api.sizeColumnsToFit();
        autoSizeAll(true)

      },

      enableCellTextSelection: true,
      ensureDomOrder: true,
      // Enable infinite scroll mode
      rowModelType: 'infinite',
      cacheBlockSize: 50,
      pagination: true,
      paginationPageSize: 20,
    };

    function autoSizeAll(skipHeader) {
      var allColumnIds = ['id'];
      // GridOption.columnApi.getAllColumns().forEach(function(column) {
      //   allColumnIds.push(column.colId);
      // });
      GridOption.columnApi.autoSizeColumns(allColumnIds, skipHeader);
    }

    return GridOption;
  };

  CORE_Framework.toNode = (htmlString) => {
    // https://stackoverflow.com/a/35385518
    const template = document.createElement('template');
    template.innerHTML = htmlString.trim();
    return template.content.firstChild;
  };

  /**
  * config :=
  * href
  *
  */
  CORE_Framework.createEdit = function (config) {
    // return this.toNode(/*html*/
    //   `<a
    //   href="${config.href}"
    //   title="Edit"
    //   class="btn btn-icon btn-light">
    //   <i class="feather icon-edit"></i>
    //   </a>`);
    return this.toNode(/*html*/
      `<a
      href="${config.href}"
      title="Edit"
      class="btn btn-icon btn-primary btn-simple update_btn">
      <i class="feather icon-edit"></i>
      </a>`);
  };

  /**
  *
  * config :=
  * id
  * classList: string
  */
  CORE_Framework.createDelete = function (config) {
    return this.toNode(/*html*/
      `<button
        data-id="${config.id}"
        title="Delete"
        class="btn btn-icon btn-danger delete_btn ${config?.classList}"
        data-toggle="modal"
        data-target="#modal">
        <i class="feather icon-trash-2"></i>
        </button>`);
  };

  /**
  * config :=
  * id
  * classList
  * isLocked
  */
  CORE_Framework.createLock = function (config) {
    return this.toNode(/*html*/
      `<button
          data-id="${config.id}"
          title=${config.isLocked ? 'Unlock' : 'Lock'}
          class="btn btn-icon ${config.isLocked ? 'btn-light' : 'btn-success'} lock_btn ${config?.classList}"
          data-toggle="modal"
          data-target="#lock">
          <i class="feather icon-${config.isLocked ? 'unlock' : 'lock'}"></i>
          </button>`);
  };

  CORE_Framework.createTemp = function (config) {
    return this.toNode(/*html*/
      `<button
            data-id="${config.id}"
            title="Generate temporary password"
            class="btn btn-icon btn-info temppass_btn ${config?.classList}"
            data-toggle="modal"
            data-target="#generateTemp"
            data-backdrop="static"
            data-keyboard="false">
            <i class="fa fa-key"></i>
            </button>`);
  };



  CORE_Framework.createcustom_btn1 = function (config) {
    return this.toNode(/*html*/
      `<button
        data-id="${config.id}"
        title="${config.button_title}"
        class="btn btn-icon ${config.btn_type} custom_btn ${config?.classList}"
        data-toggle="modal"
        data-target="#custom_modal">
        <i class="${config?.icon_class}"></i>
        </button>`);
  };
   


  CORE_Framework.makeUserControls = function (config) {
    // STUB
  };

  // Util:
  CORE_Framework.canonicalDate = function (date) {
    if (!date) return null;

    const m = date.getMonth() + 1,
      d = date.getDate();

    return date.getFullYear() + '-'
      + (m < 10 ? '0' + m : m) + '-'
      + (d < 10 ? '0' + d : d);
  };

  /**
   * Merge agGrid filter model to a custom one
   */
  CORE_Framework.mergeFilterModel = function (properties, valueSource, currentModel) {
    return properties.reduce((_a, current) => {
      if (valueSource[current] && valueSource[current] != '*') { // Filter is active?
        _a[current] = {
          filterType: 'text',
          type: 'equals',
          filter: valueSource[current],
        };
      } else { // Remove filter <current> from _a
        if (_a.hasOwnProperty(current)) {
          // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Destructuring_assignment#computed_object_property_names_and_destructuring
          let { [current]: _exclude, ...include } = _a; // e.g merchant, ...rest
          return include;
        }
      }
      return _a;
    }, currentModel);
  };

  CORE_Framework.mergeDateRange = function(property, filters, currentModel) {
    let copy = Object.assign({}, currentModel)

    if(filters.from) {
      // Note: the filter key must be a valid column in the grid;
      // dynamic properties not allowed
      copy.created_at = {
        filterType: 'text',
        type: 'contains', // custom
        filter: filters.from + ' to ' + filters.to,
      }
    } else {
      if(copy.hasOwnProperty('created_at')) {
        let { created_at, ...other } = copy; // e.g merchant, ...rest
        copy = other;
      }
    }

    return copy
  }

  CORE_Framework.asMoney = function(val) {
    return new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP'
    }).format(val)
  }

  CORE_Framework.createNumberFormatter = function() {
    return params => new Intl.NumberFormat().format(params.value)
  }

  CORE_Framework.createMoneyFormatter = function() {
    return params => new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP'
    }).format(params.value)
  }

  CORE_Framework.setFormatter = function(columns, fields, formatterFactory) {
    return columns.map((item) => {
      if(fields.indexOf(item.field) != -1) {
        return Object.assign({
          valueFormatter: formatterFactory()
        }, item)
      }
      return item
    })
  }

  _window.CORE_Framework = CORE_Framework;

})(window);
