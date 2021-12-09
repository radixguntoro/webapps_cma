var app = angular.module('factoryTuition', []);
app.factory('tuitionFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataTuition = [];
    init.totalTuitions = [];
    init.eachDataTuition = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataTuition = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'tuition/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalTuitions = response.data.total;
        }, function(response) {});
    };

    init.getDataTuition = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'tuition/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalTuitions = response.data.total;
        }, function(response) {});
    }

    init.insertDataTuition = function(input) {
        // console.log("inputan", input);
        return $http({
            method: 'POST',
            url: 'tuition/insert',
            data: {
                name: input.tuition.name,
                price: input.tuition.price,
                status: input.status,
            },
        }).then(function(response) {
            toastr.success('Data has been saved', 'Success!');
        }, function(response) {
            toastr.error('Data failed to save', 'Failed!');
        });
    }

    init.getDataEachTuition = function(input) {
        return $http({
            method: 'GET',
            url: 'tuition/edit/' + input,
        }).then(function(response) {
            init.eachDataTuition = response.data;
        }, function(response) {});
    }

    init.updateDataTuition = function(input) {
        return $http({
            method: 'POST',
            url: 'tuition/update/' + input.id,
            data: {
                name: input.tuition.name,
                price: input.tuition.price,
                status: input.status,
            },
        }).then(function(response) {
            toastr.success('Data has been changed', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    // Get Tuition Detail
    init.showTuitionDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'tuition/detail/' + input.tuition_id
        }).then(function(response) {
            init.dataTuitionDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    // Search Tuition Manual
    init.searchTuitionManual = function(searchText) {
        return $http({
            method: 'GET',
            url: 'tuition/manual?search=' + searchText.typo
        }).then(function(response) {
            init.resSearchTuition = response.data.data;
        }, function(response) {});
    }

    return init;
})
