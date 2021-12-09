var app = angular.module('factoryReportIncomeStatement', []);
app.factory('reportIncomeStatementFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportIncomeStatement = [];
    init.totalIncomeStatement = [];
    init.eachDataReportIncomeStatement = [];
    var input = {};

    init.filterDataReportIncomeStatement = function(date_start, date_end) {
        return $http({
            method: 'GET',
            url: 'reportIncomeStatement/filter?&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function(date_start, date_end) {
        return $http({
            method: 'GET',
            url: 'reportIncomeStatement/exportExcel?&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_income_statement;
            init.totalItems = response.data.total_items;
            init.totalIncomeStatement = response.data.total_income_statement;
            console.log(response);
        }, function(response) {});
    };

    return init;
})
