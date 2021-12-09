var app = angular.module('factoryHistoryTrChangeBooks', []);
app.factory('historyTrChangeBooksFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataHistoryTrChangeBooks = [];
    init.totalItems = [];
    init.eachDataHistoryTrChangeBooks = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataHistoryTrChangeBooks = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'historyTrChangeBooks/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataHistoryTrChangeBooks = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'historyTrChangeBooks/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataHistoryTrChangeBooks = function(pageNumber, dateStart, dateEnd) {
        // console.log("Date Start", dateStart);
        // console.log("Date End", dateEnd);
        return $http({
            method: 'GET',
            url: 'historyTrChangeBooks/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    return init;
})
