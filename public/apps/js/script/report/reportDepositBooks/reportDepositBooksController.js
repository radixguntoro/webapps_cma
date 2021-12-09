var app = angular.module('reportDepositBooksCtrl', ['factoryReportDepositBooks']);

app.controller('reportDepositBooksController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, reportDepositBooksFactory, studentFactory) {
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
        reportDepositBooksFactory.filterDataReportDepositBooks()
        .then(function() {
            $scope.data = reportDepositBooksFactory.resultData;
            $scope.total_deposit_books = reportDepositBooksFactory.totalDepositBooks;
            console.log($scope.data);
            $scope.loading = false;
        });
    }

    //##############################//
    //       FUNGSI SORT DATA       //
    //##############################//
    $scope.sortColumn = "student_id";
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
        var url = 'reportDepositBooks/exportExcel';
        $window.open(url);
    }
})
