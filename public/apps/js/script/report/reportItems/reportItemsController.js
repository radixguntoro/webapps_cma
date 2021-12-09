var app = angular.module('reportItemsCtrl', ['factoryReportItems']);

app.controller('reportItemsController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, reportItemsFactory, studentFactory) {
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
        reportItemsFactory.filterDataReportItems()
        .then(function() {
            $scope.data = reportItemsFactory.resultData;
            $scope.total_price_buy = reportItemsFactory.totalPriceBuy;
            $scope.total_price_sell = reportItemsFactory.totalPriceSell;
            console.log($scope.data);
            $scope.loading = false;
        });
    }

    //##############################//
    //       FUNGSI SORT DATA       //
    //##############################//
    $scope.sortColumn = "id";
    $scope.reverseSort = true;

    $scope.sortData = function(column) {
        $scope.reverseSort = ($scope.sortColumn == column) ? !$scope.reverseSort : false;
        $scope.sortColumn = column;
    }

    $scope.getSortClass = function(column) {
        if ($scope.sortColumn == column) {
            return $scope.reverseSort ? 'sort-desc' : 'sort-asc'
        }

        return '';
    }

    //##############################//
    //      FUNGSI EXPORT EXCEL     //
    //##############################//
    $scope.exportExcel = function() {
        var url = 'reportItems/exportExcel';
        $window.open(url);
    }
})
