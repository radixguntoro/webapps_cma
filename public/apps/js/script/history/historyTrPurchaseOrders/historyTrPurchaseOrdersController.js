var app = angular.module('historyTrPurchaseOrdersCtrl', ['factoryHistoryTrPurchaseOrders']);

app.controller('historyTrPurchaseOrdersController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, historyTrPurchaseOrdersFactory) {
    //##############################//
    //      DEKLARASI VARIABLE      //
    //##############################//
    $rootScope.$state = $state;
    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalItemsTemp = {};
    $scope.totalItems = 0;
    $scope.pagination = {
        current: 1
    };

    $scope.historyTrPurchaseOrders = {};
    $scope.report = {};

    $scope.dateReportOptions = {
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    };

    $scope.report.datestart = $filter('date')('01-01-2010', 'yyyy-MM-dd');
    $scope.report.dateend = $filter('date')(new Date(), 'yyyy-MM-dd');

    //##############################//
    //   List, Pagination, Search   //
    //##############################//
    $scope.getResultsPage = function(pageNumber) {
        $scope.loading = true;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            var dateStart = $scope.report.datestart != null ? $filter('date')($scope.report.datestart, 'yyyy-MM-dd') : '';
            var dateEnd = $scope.report.dateend != null ? $filter('date')($scope.report.dateend, 'yyyy-MM-dd') : '';
            historyTrPurchaseOrdersFactory.filterDataHistoryTrPurchaseOrders(pageNumber, dateStart, dateEnd)
                .then(function() {
                    $scope.data = historyTrPurchaseOrdersFactory.resultData;
                    $scope.totalItems = historyTrPurchaseOrdersFactory.totalItems;
                    $scope.loading = false;
                });
        } else {
            historyTrPurchaseOrdersFactory.getDataHistoryTrPurchaseOrders(pageNumber)
                .then(function() {
                    $scope.data = historyTrPurchaseOrdersFactory.resultData;
                    $scope.totalItems = historyTrPurchaseOrdersFactory.totalItems;
                    $scope.loading = false;
                    console.log($scope.data);
                });
        }
    }

    $scope.pageChanged = function(newPage) {
        $scope.getResultsPage(newPage);
    };

    $scope.getResultsPage(1);

    //##############################//
    //      FUNGSI FILTER DATA      //
    //##############################//
    $scope.filterData = function() {
        if ($.isEmptyObject($scope.libraryTemp)) {
            $scope.libraryTemp = $scope.data;
            $scope.totalItemsTemp = $scope.totalItems;
            $scope.data = {};
        }
        $scope.getResultsPage(1);
    }

    //##############################//
    //       FUNGSI HAPUS DATA      //
    //##############################//
    $scope.deleteDataHistoryTrPurchaseOrders = function(data) {
        historyTrPurchaseOrdersFactory.deleteDataHistoryTrPurchaseOrders({
            id: data.id
        }).then(function() {
            $state.go($state.current, {}, {
                reload: true
            });
        });
    }
})
