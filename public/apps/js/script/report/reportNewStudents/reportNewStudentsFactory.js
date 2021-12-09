var app = angular.module('factoryReportNewStudents', []);
app.factory('reportNewStudentsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportNewStudents = [];
    init.totalNewStudents = [];
    init.eachDataReportNewStudents = [];
    var input = {};

    init.filterDataReportNewStudents = function(date_start, date_end, student_id) {
        return $http({
            method: 'GET',
            url: 'reportNewStudents/filter?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_new_students;
            init.totalItems = response.data.total_items;
            init.totalNewStudents = response.data.total_new_students;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function(date_start, date_end, student_id) {
        console.log("User", date_start);
        return $http({
            method: 'GET',
            url: 'reportNewStudents/exportExcel?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_new_students;
            init.totalItems = response.data.total_items;
            init.totalNewStudents = response.data.total_new_students;
            console.log(response);
        }, function(response) {});
    };

    return init;
})
