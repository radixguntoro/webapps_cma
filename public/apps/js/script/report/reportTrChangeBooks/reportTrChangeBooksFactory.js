var app = angular.module('factoryReportTrChangeBooks', []);
app.factory('reportTrChangeBooksFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportTrChangeBooks = [];
    init.totalItems = [];
    init.eachDataReportTrChangeBooks = [];
    var input = {};

    init.filterDataReportTrChangeBooks = function(date_start, date_end, student_id) {
        return $http({
            method: 'GET',
            url: 'reportTrChangeBooks/filter?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_tr_change_books;
            init.totalItems = response.data.total_items;
            init.totalTrChangeBooks = response.data.total_tr_change_books;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function(date_start, date_end, student_id) {
        console.log("User", date_start);
        return $http({
            method: 'GET',
            url: 'reportTrChangeBooks/exportExcel?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_tr_change_books;
            init.totalItems = response.data.total_items;
            init.totalTrChangeBooks = response.data.total_tr_change_books;
            console.log(response);
        }, function(response) {});
    };

    // Get Transaction Sales Detail
    init.showTrChangeBooksDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'reportTrChangeBooks/detail/' + input.tr_change_books_id
        }).then(function(response) {
            init.dataTrChangeBooksDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    return init;
})
