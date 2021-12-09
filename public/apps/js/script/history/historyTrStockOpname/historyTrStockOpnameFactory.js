var app = angular.module('factoryHistoryTrPurchaseOrderStamps', []);
app.factory('historyTrPurchaseOrderStampsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataHistoryTrPurchaseOrderStamps = [];
    init.totalItems = [];
    init.eachDataHistoryTrPurchaseOrderStamps = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataHistoryTrPurchaseOrderStamps = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'historyTrPurchaseOrderStamps/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataHistoryTrPurchaseOrderStamps = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'historyTrPurchaseOrderStamps/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataHistoryTrPurchaseOrderStamps = function(pageNumber, dateStart, dateEnd) {
        // console.log("Date Start", dateStart);
        // console.log("Date End", dateEnd);
        return $http({
            method: 'GET',
            url: 'historyTrPurchaseOrderStamps/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    return init;
})
