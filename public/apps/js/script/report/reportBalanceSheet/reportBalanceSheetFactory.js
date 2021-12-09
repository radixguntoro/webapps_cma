var app = angular.module('factoryReportBalanceSheet', []);
app.factory('reportBalanceSheetFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.totalItems = [];
    var input = {};

    // Count Data
    init.getCountData = function() {
        return $http({
            method: 'GET',
            url: 'reportBalanceSheet/getCountData'
        }).then(function(response) {
            init.resultData = response;
        }, function(response) {});
    };

    return init;
})
