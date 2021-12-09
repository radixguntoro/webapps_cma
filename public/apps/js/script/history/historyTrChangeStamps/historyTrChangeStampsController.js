var app = angular.module('historyTrChangeStampsCtrl', ['factoryHistoryTrChangeStamps']);

app.controller('historyTrChangeStampsController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, historyTrChangeStampsFactory) {
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

    $scope.historyTrChangeStamps = {};
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
            historyTrChangeStampsFactory.filterDataHistoryTrChangeStamps(pageNumber, dateStart, dateEnd)
                .then(function() {
                    $scope.data = historyTrChangeStampsFactory.resultData;
                    $scope.totalItems = historyTrChangeStampsFactory.totalItems;
                    $scope.loading = false;
                });
        } else {
            historyTrChangeStampsFactory.getDataHistoryTrChangeStamps(pageNumber)
                .then(function() {
                    $scope.data = historyTrChangeStampsFactory.resultData;
                    $scope.totalItems = historyTrChangeStampsFactory.totalItems;
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
    $scope.deleteDataHistoryTrChangeStamps = function(data) {
        historyTrChangeStampsFactory.deleteDataHistoryTrChangeStamps({
            id: data.id
        }).then(function() {
            $state.go($state.current, {}, {
                reload: true
            });
        });
    }
})
