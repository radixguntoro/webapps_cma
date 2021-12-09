var app = angular.module('factoryUser', []);
app.factory('userFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataUser = [];
    init.totalItems = [];
    init.eachDataUser = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataUser = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'user/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataUser = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'user/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.insertDataUser = function(input) {
        console.log(input);
        return $http({
            method: 'POST',
            url: 'user/insert',
            data: {
                name: input.user.name,
                join_date: input.user.join_date,
                email: input.user.email,
                password: input.user.password,
                permission: input.permission,
                status: input.status
            },
        }).then(function(response) {
            toastr.success('Data has been saved', 'Success!');
        }, function(response) {
            toastr.error('Data failed to save', 'Failed!');
        });
    }

    init.getDataEachUser = function(input) {
        return $http({
            method: 'GET',
            url: 'user/edit/' + input,
        }).then(function(response) {
            init.eachDataUser = response.data;
        }, function(response) {});
    }

    init.updateDataUser = function(input) {
        console.log("Data Input", input);
        return $http({
            method: 'POST',
            url: 'user/update/' + input.id,
            data: {
                name: input.user.name,
                join_date: input.user.join_date,
                email: input.user.email,
                password: input.user.password,
                permission: input.permission,
                status: input.status
            }
        }).then(function(response) {
            toastr.success('Data has been changed', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    // Get User Detail
    init.showUserDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'user/detail/' + input.user_id
        }).then(function(response) {
            init.dataUserDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    init.getAllDataUser = function() {
        return $http({
            method: 'GET',
            url: 'user/all',
        }).then(function(response) {
            init.allDataUser = response.data;
            console.log("Tes", response.data);
        }, function(response) {});
    }

    return init;
})
