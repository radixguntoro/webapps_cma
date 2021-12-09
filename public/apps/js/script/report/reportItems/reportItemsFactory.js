var app = angular.module('factoryReportItems', []);
app.factory('reportItemsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportItems = [];
    init.totalItems = [];
    init.eachDataReportItems = [];
    var input = {};

    init.filterDataReportItems = function() {
        return $http({
            method: 'GET',
            url: 'reportItems/filter'
        }).then(function(response) {
            init.resultData = response.data.report_items;
            init.totalPriceBuy = response.data.total_price_buy;
            init.totalPriceSell = response.data.total_price_sell;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function() {
        return $http({
            method: 'GET',
            url: 'reportItems/exportExcel'
        }).then(function(response) {
            init.resultData = response.data.report_items;
            init.totalItems = response.data.total_items;
            console.log(response);
        }, function(response) {});
    };

    // Get Transaction Sales Detail
    init.showItemsDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'reportItems/detail/' + input.items_id
        }).then(function(response) {
            init.dataItemsDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    return init;
})
