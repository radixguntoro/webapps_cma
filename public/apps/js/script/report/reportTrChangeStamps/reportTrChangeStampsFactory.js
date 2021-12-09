var app = angular.module('factoryReportTrChangeStamps', []);
app.factory('reportTrChangeStampsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportTrChangeStamps = [];
    init.totalItems = [];
    init.eachDataReportTrChangeStamps = [];
    var input = {};

    init.filterDataReportTrChangeStamps = function(date_start, date_end, student_id) {
        return $http({
            method: 'GET',
            url: 'reportTrChangeStamps/filter?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_tr_change_stamps;
            init.totalItems = response.data.total_items;
            init.totalTrChangeStamps = response.data.total_tr_change_stamps;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function(date_start, date_end, student_id) {
        console.log("User", date_start);
        return $http({
            method: 'GET',
            url: 'reportTrChangeStamps/exportExcel?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_tr_change_stamps;
            init.totalItems = response.data.total_items;
            init.totalTrChangeStamps = response.data.total_tr_change_stamps;
            console.log(response);
        }, function(response) {});
    };

    // Get Transaction Sales Detail
    init.showTrChangeStampsDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'reportTrChangeStamps/detail/' + input.tr_change_stamps_id
        }).then(function(response) {
            init.dataTrChangeStampsDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    return init;
})
