var app = angular.module('factoryReportPurchaseOrderRewards', []);
app.factory('reportPurchaseOrderRewardsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportPurchaseOrderRewards = [];
    init.totalPurchaseOrderRewards = [];
    init.eachDataReportPurchaseOrderRewards = [];
    var input = {};

    init.filterDataReportPurchaseOrderRewards = function(date_start, date_end) {
        return $http({
            method: 'GET',
            url: 'reportPurchaseOrderRewards/filter?datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_purchase_order_rewards;
            init.totalItems = response.data.total_items;
            init.totalPurchaseOrderRewards = response.data.total_purchase_order_rewards;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function(date_start, date_end) {
        console.log("User", date_start);
        return $http({
            method: 'GET',
            url: 'reportPurchaseOrderRewards/exportExcel?datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_purchase_order_rewards;
            init.totalItems = response.data.total_items;
            init.totalPurchaseOrderRewards = response.data.total_purchase_order_rewards;
            console.log(response);
        }, function(response) {});
    };

    return init;
})
