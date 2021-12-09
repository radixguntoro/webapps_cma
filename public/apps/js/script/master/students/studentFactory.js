var app = angular.module('factoryStudent', []);
app.factory('studentFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataStudent = [];
    init.totalItems = [];
    init.eachDataStudent = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataStudent = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'student/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataStudent = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'student/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.insertDataStudent = function(input) {
        console.log(input);
        return $http({
            method: 'POST',
            url: 'student/insert',
            data: {
                code: input.student.code,
                name: input.student.name,
                join_date: input.student.join_date,
                deposit: input.student.deposit,
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

    init.getDataEachStudent = function(input) {
        return $http({
            method: 'GET',
            url: 'student/edit/' + input,
        }).then(function(response) {
            init.eachDataStudent = response.data;
        }, function(response) {});
    }

    init.updateDataStudent = function(input) {
        console.log("Data Input", input);
        return $http({
            method: 'POST',
            url: 'student/update/' + input.id,
            data: {
                code: input.student.code,
                name: input.student.name,
                join_date: input.student.join_date,
                deposit: input.student.deposit,
                status: input.status
            }
        }).then(function(response) {
            toastr.success('Data has been changed', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    init.getAllDataStudent = function() {
        return $http({
            method: 'GET',
            url: 'student/all',
        }).then(function(response) {
            init.allDataStudent = response.data;
        }, function(response) {});
    }

    // Get Student Detail
    init.showStudentDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'student/detail/' + input.student_id
        }).then(function(response) {
            init.dataStudentDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    init.searchStudentManual = function(searchText) {
        return $http({
            method: 'GET',
            url: 'student/manual?search=' + searchText.typo
        }).then(function(response) {
            init.resSearchStudent = response.data.data;
        }, function(response) {});
    }

    return init;
})
