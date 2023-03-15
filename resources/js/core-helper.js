//
// agGridHelper.js
//
// Automates ag-grid common functions

var CoreHttp = {};
var _S = {};

CoreHttp.getPage = function(path, page, size) {
    var req = new XMLHttpRequest();

    // config
    //

    return new Promise(req.start());
}

var AgGridHelper = function(config) {
    this.ag = gridElement;

    this.pageNum = 1;
    this.pageSize = 10;

    this.ag.onNext = () => {

    }

    this.ag.onPrev = () => {

    }
}

AgGridHelper.prototype._init = function(config) {
    if(config.controls.indexOf('edit') != -1) {
        // create edit button
        let edit = document.createElement('a');

        // on click etc...
        // edit.addEventListener('click', () => {
        //     windows.location.href = this.resource + '/edit' +
        // });

    }

    if(config.controls.indexOf('delete') != -1) {

    }

};


// Usage:
let config = {
    resource: '/user_level',
    pageSize: 10,
    agGrid: _S('#grid'),
    prev: _S('#prevbtn'),
    next: _S('#nextbtn'),
    controls: ['add', 'edit' ]
};

new AgGridHelper(config);