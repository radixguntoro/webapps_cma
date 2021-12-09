var app = angular.module('reportStockGiftRewardsCtrl', ['factoryReportStockGiftRewards']);

app.controller('reportStockGiftRewardsController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, reportStockGiftRewardsFactory, stampFactory) {
    //##############################//
    //      DEKLARASI VARIABLE      //
    //##############################//
    $rootScope.$state = $state;
    $scope.data = [];
    $scope.report = {};

    $scope.dateReportOptions = {
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    };

    //##############################//
    //      FUNGSI FILTER DATA      //
    //##############################//
    $scope.filterData = function() {
        $scope.loading = true;
        reportStockGiftRewardsFactory.filterDataReportStockGiftRewards()
        .then(function() {
            $scope.data = reportStockGiftRewardsFactory.resultData;
            $scope.total_stock_gift_rewards = reportStockGiftRewardsFactory.totalStockGiftRewards;
            $scope.stamp_stock_gift_rewards = reportStockGiftRewardsFactory.stampStockGiftRewards;
            console.log($scope.data);
            $scope.loading = false;
        });
    }

    //##############################//
    //       FUNGSI SORT DATA       //
    //##############################//
    $scope.sortColumn = "stamp_id";
    $scope.reverseSort = false;

    $scope.sortData = function(column) {
        $scope.reverseSort = ($scope.sortColumn == column) ? !$scope.reverseSort : false;
        $scope.sortColumn = column;
    }

    $scope.getSortClass = function(column) {
        if ($scope.sortColumn == column) {
            return $scope.reverseSort ? 'sort-asc' : 'sort-desc'
        }

        return '';
    }

    //##############################//
    //      FUNGSI EXPORT EXCEL     //
    //##############################//
    $scope.exportExcel = function() {
        var url = 'reportStockGiftRewards/exportExcel';
        $window.open(url);
    }
})
