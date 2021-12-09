var app = angular.module('factoryReportStockOpname', []);
app.factory('reportStockOpnameFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportStockOpname = [];
    init.totalItems = [];
    init.eachDataReportStockOpname = [];
    var input = {};

    init.filterDataReportStockOpname = function(dateStart, dateEnd) {
        return $http({
            method: 'GET',
            url: 'reportStockOpname/filter?datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.report_stock_opname;
            init.resultTotal = response.data.total_stock_opname;
        }, function(response) {});
    };

    // Get Transaction Sales Detail
    init.showStockOpnameDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'reportStockOpname/detail/' + input.stock_opname_id
        }).then(function(response) {
            init.dataStockOpnameDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    return init;
})
