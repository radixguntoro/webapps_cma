var app = angular.module('databaseCtrl', ['factoryDatabase']);

app.controller('databaseController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, databaseFactory) {
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
            databaseFactory.filterDatabase(pageNumber, dateStart, dateEnd)
                .then(function() {
                    $scope.data = databaseFactory.resultData;
                    $scope.totalItems = databaseFactory.totalItems;
                    $scope.loading = false;
                });
        } else {
            databaseFactory.getDatabase(pageNumber)
                .then(function() {
                    $scope.data = databaseFactory.resultData;
                    $scope.totalItems = databaseFactory.totalItems;
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
    //      FUNGSI BACKUP DATA      //
    //##############################//
    $scope.backUpData = function() {
        $scope.loading = true;
        databaseFactory.backUpData()
        .then(function() {
            $scope.loading = false;
            $scope.getResultsPage(1);
        });
    }

    //##############################//
    //      FUNGSI DOWNLOAD DATA      //
    //##############################//
    $scope.downloadData = function(elm, input) {
        $scope.loading = true;
        databaseFactory.downloadData({
            filename: input.file_name
        })
        .then(function() {
            var validation = databaseFactory.resultDownload;
            if (validation == 0) {
                $scope.loading = false;
                return;
            } else {
                $scope.loading = false;
                var url = 'database/download/' + input.file_name;
                $window.open(url);
                $window.close();
                $timeout(function(){
                    toastr.info('Please check in your folder', 'Info!');
                }, 500);
            }
        });
    }

    //##############################//
    //       FUNGSI SORT DATA       //
    //##############################//
    $scope.sortColumn = "date";
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
})
