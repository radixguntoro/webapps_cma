var app = angular.module('factoryDashboard', []);
app.factory('dashboardFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.totalItems = [];
    var input = {};

    // Count Data
    init.getCountData = function() {
        return $http({
            method: 'GET',
            url: 'dashboard/getCountData'
        }).then(function(response) {
            init.resultData = response;
            // console.log("Data", init.resultData);
        }, function(response) {});
    };

    return init;
})
