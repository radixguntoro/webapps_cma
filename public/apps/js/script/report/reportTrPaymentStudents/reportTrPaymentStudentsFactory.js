var app = angular.module('factoryReportTrPaymentStudents', []);
app.factory('reportTrPaymentStudentsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataReportTrPaymentStudents = [];
    init.totalItems = [];
    init.eachDataReportTrPaymentStudents = [];
    var input = {};

    init.filterDataReportTrPaymentStudents = function(date_start, date_end, student_id) {
        return $http({
            method: 'GET',
            url: 'reportTrPaymentStudents/filter?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_tr_payments;
            init.totalItems = response.data.total_items;
            init.totalTrPayments = response.data.total_tr_payments;
            console.log(response);
        }, function(response) {});
    };

    // Export Excel
    init.exportExcel = function(date_start, date_end, student_id) {
        console.log("User", date_start);
        return $http({
            method: 'GET',
            url: 'reportTrPaymentStudents/exportExcel?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function(response) {
            init.resultData = response.data.report_tr_payments;
            init.totalItems = response.data.total_items;
            init.totalTrPayments = response.data.total_tr_payments;
            console.log(response);
        }, function(response) {});
    };

    // Get Transaction Sales Detail
    init.showTrPaymentsDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'reportTrPaymentStudents/detail/' + input.tr_payments_id
        }).then(function(response) {
            init.dataTrPaymentsDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    return init;
})
