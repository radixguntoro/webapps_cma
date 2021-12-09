var app = angular.module('factoryHistoryTrPayments', []);
app.factory('historyTrPaymentsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataHistoryTrPayments = [];
    init.totalItems = [];
    init.eachDataHistoryTrPayments = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataHistoryTrPayments = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'historyTrPayments/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataHistoryTrPayments = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'historyTrPayments/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataHistoryTrPayments = function(pageNumber, dateStart, dateEnd) {
        // console.log("Date Start", dateStart);
        // console.log("Date End", dateEnd);
        return $http({
            method: 'GET',
            url: 'historyTrPayments/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    return init;
})
