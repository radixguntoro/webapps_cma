var app = angular.module('factoryHistoryTrChangeStamps', []);
app.factory('historyTrChangeStampsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataHistoryTrChangeStamps = [];
    init.totalItems = [];
    init.eachDataHistoryTrChangeStamps = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataHistoryTrChangeStamps = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'historyTrChangeStamps/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataHistoryTrChangeStamps = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'historyTrChangeStamps/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataHistoryTrChangeStamps = function(pageNumber, dateStart, dateEnd) {
        // console.log("Date Start", dateStart);
        // console.log("Date End", dateEnd);
        return $http({
            method: 'GET',
            url: 'historyTrChangeStamps/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    return init;
})
