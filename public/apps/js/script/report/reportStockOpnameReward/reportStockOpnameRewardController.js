var app = angular.module('reportStockOpnameRewardCtrl', ['factoryReportStockOpnameReward']);

app.controller('reportStockOpnameRewardController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, reportStockOpnameRewardFactory) {
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

    $scope.reportStockOpnameReward = {};
    $scope.report = {};

    $scope.dateReportOptions = {
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    };
    $scope.report.datestart = $filter('date')(new Date(), 'yyyy-MM-dd');
    // $scope.report.datestart = $filter('date')('01-01-2010', 'yyyy-MM-dd');
    $scope.report.dateend = $filter('date')(new Date(), 'yyyy-MM-dd');

    //##############################//
    //      FUNGSI FILTER DATA      //
    //##############################//
    $scope.filterData = function() {
        if ($scope.report.datestart == null || $scope.report.dateend == null) {
            toastr.error('Pilihan Tanggal masih kosong', 'Pencarian Gagal!');
            return true;
        } else {
            $scope.loading = true;
            var dateStart = $scope.report.datestart != null ? $filter('date')($scope.report.datestart, 'yyyy-MM-dd') : '';
            var dateEnd = $scope.report.dateend != null ? $filter('date')($scope.report.dateend, 'yyyy-MM-dd') : '';

            reportStockOpnameRewardFactory.filterDataReportStockOpnameReward(dateStart, dateEnd)
            .then(function() {
                $scope.data = reportStockOpnameRewardFactory.resultData;
                $scope.total = reportStockOpnameRewardFactory.resultTotal;
                $scope.loading = false;
            });
        }
    }

    //##############################//
    //       FUNGSI SORT DATA       //
    //##############################//
    $scope.sortColumn = "date";
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
        var date_start = $scope.report.datestart != null ? $filter('date')($scope.report.datestart, 'yyyy-MM-dd') : '';
        var date_end = $scope.report.dateend != null ? $filter('date')($scope.report.dateend, 'yyyy-MM-dd') : '';

        if ($scope.report.datestart == null || $scope.report.dateend == null) {
            toastr.error('Pilihan Tanggal masih kosong', 'Pencarian Gagal!');
            return true;
        } else {
            var url = 'reportStockOpnameReward/exportExcel?datestart=' + date_start + '&dateend=' + date_end;
            $window.open(url);
            $scope.loading = false;
        }
    }
})
