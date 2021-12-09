var app = angular.module('factoryStamp', []);
app.factory('stampFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataStamp = [];
    init.totalStamps = [];
    init.eachDataStamp = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataStamp = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'stamp/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalStamps = response.data.total;
        }, function(response) {});
    };

    init.getDataStamp = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'stamp/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalStamps = response.data.total;
        }, function(response) {});
    }

    init.insertDataStamp = function(input) {
        // console.log("inputan", input);
        return $http({
            method: 'POST',
            url: 'stamp/insert',
            data: {
                name: input.stamp.name,
                stamp: input.stamp.stamp,
                price: input.stamp.price,
                qty: input.stamp.qty,
                status: input.status
            },
        }).then(function(response) {
            if (response.data == 'invalid') {
                init.resultInsert = "invalid";
            } else {
                init.resultInsert = "valid";
            }
        }, function(response) {
            toastr.error('Data failed to save', 'Failed!');
        });
    }

    init.getDataEachStamp = function(input) {
        return $http({
            method: 'GET',
            url: 'stamp/edit/' + input,
        }).then(function(response) {
            init.eachDataStamp = response.data;
        }, function(response) {});
    }

    init.updateDataStamp = function(input) {
        return $http({
            method: 'POST',
            url: 'stamp/update/' + input.id,
            data: {
                name: input.stamp.name,
                stamp: input.stamp.stamp,
                price: input.stamp.price,
                qty: input.stamp.qty,
                status: input.status
            },
        }).then(function(response) {
            toastr.success('Data has been changed', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    // Get Stamp Detail
    init.showStampDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'stamp/detail/' + input.stamp_id
        }).then(function(response) {
            init.dataStampDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    // Search Stamp Manual
    init.searchStampManual = function(searchText) {
        return $http({
            method: 'GET',
            url: 'stamp/manual?search=' + searchText.typo
        }).then(function(response) {
            init.resSearchStamp = response.data.data;
        }, function(response) {});
    }

    init.getAllDataStamp = function() {
        return $http({
            method: 'GET',
            url: 'stamp/all',
        }).then(function(response) {
            init.allDataStamp = response.data;
        }, function(response) {});
    }

    init.getMinStockStamp = function() {
        return $http({
            method: 'GET',
            url: 'stamp/min-stock',
        }).then(function(response) {
            init.minStockStamp = response.data;
        }, function(response) {});
    }

    // Search Item Manual
    init.searchStamp = function(searchText) {
        return $http({
            method: 'GET',
            url: 'stamp/search?stamp=' + searchText.typo
        }).then(function(response) {
            init.resSearchStamp = response.data.data;
        }, function(response) {});
    }

    return init;
})
