var app = angular.module('factoryDatabase', []);
app.factory('databaseFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataDatabase = [];
    init.totalDepositBooks = [];
    init.eachDataDatabase = [];
    var input = {};

    // Pagination and Search Function
    init.searchDatabase = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'database/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDatabase = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'database/list?page=' + pageNumber
        }).then(function(response) {
            if (response.data == 'empty') {
                init.resultData = [];
                return;
            } else {
                init.resultData = response.data.data;
                init.totalItems = response.data.total;
            }
        }, function(response) {});
    }

    init.filterDatabase = function(pageNumber, dateStart, dateEnd) {
        // console.log("Date Start", dateStart);
        // console.log("Date End", dateEnd);
        return $http({
            method: 'GET',
            url: 'database/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.backUpData = function() {
        return $http({
            method: 'POST',
            url: 'database/backup'
        }).then(function(response) {
            if (response.data == 'success') {
                toastr.success('Backup is successful', 'Success!');
                return;
            } else {
                toastr.error('Backup is failed', 'Failed!');
                return;
            }
        }, function(response) {});
    };

    init.downloadData = function(input) {
        console.log(input);
        return $http({
            method: 'GET',
            url: 'database/download/' + input.filename,
        }).then(function(response) {
            if (response.data == 'error') {
                init.resultDownload = 0;
                toastr.error('Download has been failed', 'Failed!');
                return;
            } else {
                init.resultDownload = 1;
                toastr.success('Download has been successful', 'Success!');
                return;
            }
        }, function(response) {});
    };

    return init;
})
