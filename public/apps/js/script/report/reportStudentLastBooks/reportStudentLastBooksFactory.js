var app = angular.module('factoryReportStudentLastBooks', []);
app.factory('reportStudentLastBooksFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportStudentLastBooks = [];
    init.totalStudentLastBooks = [];
    init.eachDataReportStudentLastBooks = [];
    var input = {};

    init.filterDataReportStudentLastBooks = function() {
        return $http({
            method: 'GET',
            url: 'reportStudentLastBooks/filter'
        }).then(function(response) {
            init.resultData = response.data.report_student_last_books;
            init.totalStudentLastBooks = response.data.total_student_last_books;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function() {
        return $http({
            method: 'GET',
            url: 'reportStudentLastBooks/exportExcel'
        }).then(function(response) {
            init.resultData = response.data.report_student_last_books;
            init.totalStudentLastBooks = response.data.total_student_last_books;
            console.log(response);
        }, function(response) {});
    };

    return init;
})
