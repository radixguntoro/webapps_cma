var app = angular.module('factoryReportDepositBooks', []);
app.factory('reportDepositBooksFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportDepositBooks = [];
    init.totalDepositBooks = [];
    init.eachDataReportDepositBooks = [];
    var input = {};

    init.filterDataReportDepositBooks = function() {
        return $http({
            method: 'GET',
            url: 'reportDepositBooks/filter'
        }).then(function(response) {
            init.resultData = response.data.report_deposit_books;
            init.totalDepositBooks = response.data.total_deposit_books;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function() {
        return $http({
            method: 'GET',
            url: 'reportDepositBooks/exportExcel'
        }).then(function(response) {
            init.resultData = response.data.report_deposit_books;
            init.totalDepositBooks = response.data.total_deposit_books;
            console.log(response);
        }, function(response) {});
    };

    return init;
})
