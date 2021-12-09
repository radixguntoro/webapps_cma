var app = angular.module('factoryHistoryTrPurchaseOrders', []);
app.factory('historyTrPurchaseOrdersFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataHistoryTrPurchaseOrders = [];
    init.totalItems = [];
    init.eachDataHistoryTrPurchaseOrders = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataHistoryTrPurchaseOrders = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'historyTrPurchaseOrders/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataHistoryTrPurchaseOrders = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'historyTrPurchaseOrders/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataHistoryTrPurchaseOrders = function(pageNumber, dateStart, dateEnd) {
        // console.log("Date Start", dateStart);
        // console.log("Date End", dateEnd);
        return $http({
            method: 'GET',
            url: 'historyTrPurchaseOrders/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    return init;
})
