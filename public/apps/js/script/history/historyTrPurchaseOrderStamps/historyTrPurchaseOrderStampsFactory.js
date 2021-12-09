var app = angular.module('factoryHistoryTrStockOpname', []);
app.factory('historyTrStockOpnameFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataHistoryTrStockOpname = [];
    init.totalItems = [];
    init.eachDataHistoryTrStockOpname = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataHistoryTrStockOpname = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'historyTrStockOpname/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataHistoryTrStockOpname = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'historyTrStockOpname/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataHistoryTrStockOpname = function(pageNumber, dateStart, dateEnd) {
        // console.log("Date Start", dateStart);
        // console.log("Date End", dateEnd);
        return $http({
            method: 'GET',
            url: 'historyTrStockOpname/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    return init;
})
