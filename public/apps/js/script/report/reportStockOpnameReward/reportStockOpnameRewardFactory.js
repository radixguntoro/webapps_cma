var app = angular.module('factoryReportStockOpnameReward', []);
app.factory('reportStockOpnameRewardFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportStockOpnameReward = [];
    init.totalItems = [];
    init.eachDataReportStockOpnameReward = [];
    var input = {};

    init.filterDataReportStockOpnameReward = function(dateStart, dateEnd) {
        return $http({
            method: 'GET',
            url: 'reportStockOpnameReward/filter?datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.report_stock_opname;
            init.resultTotal = response.data.total_stock_opname;
        }, function(response) {});
    };

    return init;
})
