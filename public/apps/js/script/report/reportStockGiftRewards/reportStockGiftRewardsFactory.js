var app = angular.module('factoryReportStockGiftRewards', []);
app.factory('reportStockGiftRewardsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportStockGiftRewards = [];
    init.totalStockGiftRewards = [];
    init.eachDataReportStockGiftRewards = [];
    var input = {};

    init.filterDataReportStockGiftRewards = function() {
        return $http({
            method: 'GET',
            url: 'reportStockGiftRewards/filter'
        }).then(function(response) {
            init.resultData = response.data.report_stock_gift_rewards;
            init.totalStockGiftRewards = response.data.total_stock_gift_rewards;
            init.stampStockGiftRewards = response.data.stamp_stock_gift_rewards;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function() {
        return $http({
            method: 'GET',
            url: 'reportStockGiftRewards/exportExcel'
        }).then(function(response) {
            init.resultData = response.data.report_stocks;
            init.totalStockGiftRewards = response.data.total_stock_gift_rewards;
            console.log(response);
        }, function(response) {});
    };

    return init;
})
