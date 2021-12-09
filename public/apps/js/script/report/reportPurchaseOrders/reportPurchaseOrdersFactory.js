var app = angular.module('factoryReportPurchaseOrders', []);
app.factory('reportPurchaseOrdersFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportPurchaseOrders = [];
    init.totalPurchaseOrders = [];
    init.eachDataReportPurchaseOrders = [];
    var input = {};

    init.filterDataReportPurchaseOrders = function(date_start, date_end) {
        return $http({
            method: 'GET',
            url: 'reportPurchaseOrders/filter?datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_purchase_orders;
            init.totalItems = response.data.total_items;
            init.totalPurchaseOrders = response.data.total_purchase_orders;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function(date_start, date_end) {
        console.log("User", date_start);
        return $http({
            method: 'GET',
            url: 'reportPurchaseOrders/exportExcel?datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_purchase_orders;
            init.totalItems = response.data.total_items;
            init.totalPurchaseOrders = response.data.total_purchase_orders;
            console.log(response);
        }, function(response) {});
    };

    return init;
})
