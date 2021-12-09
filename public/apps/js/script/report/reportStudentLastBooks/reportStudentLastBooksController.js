var app = angular.module('reportStudentLastBooksCtrl', ['factoryReportStudentLastBooks']);

app.controller('reportStudentLastBooksController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, reportStudentLastBooksFactory, studentFactory) {
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
        reportStudentLastBooksFactory.filterDataReportStudentLastBooks()
        .then(function() {
            $scope.data = reportStudentLastBooksFactory.resultData;
            $scope.total_student_last_books = reportStudentLastBooksFactory.totalStudentLastBooks;
            console.log($scope.data);
            $scope.loading = false;
        });
    }

    //##############################//
    //       FUNGSI SORT DATA       //
    //##############################//
    $scope.sortColumn = "student_id";
    $scope.reverseSort = true;

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
        var url = 'reportStudentLastBooks/exportExcel';
        $window.open(url);
    }
})
