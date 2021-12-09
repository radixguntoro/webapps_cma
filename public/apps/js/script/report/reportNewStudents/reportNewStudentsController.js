var app = angular.module('reportNewStudentsCtrl', ['factoryReportNewStudents']);

app.controller('reportNewStudentsController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, reportNewStudentsFactory, studentFactory) {
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
    $scope.report.datestart = $filter('date')(new Date(), 'yyyy-MM-dd');
    // $scope.report.datestart = $filter('date')('01-01-2010', 'yyyy-MM-dd');
    $scope.report.dateend = $filter('date')(new Date(), 'yyyy-MM-dd');

    //##############################//
    //      PENCARIAN STUDENT       //
    //##############################//
    $scope.searchStudent = function(typo, response) {
        studentFactory.searchStudentManual({
            typo: typo.term
        }).then(function() {
            $scope.data_student = studentFactory.resSearchStudent;
            if ($scope.data_student.length > 0) {
                response($scope.data_student);
            } else {
                response([{id: "0", name: "Maaf, data tidak ditemukan"}]);
            }
        });
    };

    //##############################//
    //   MENGAMBIL DATA STUDENT     //
    //##############################//
    $scope.getStudent = function(input) {
        $scope.loadingSupp = true;
        studentFactory.showStudentDetail({
            student_id: input.id
        }).then(function() {
            $scope.report.student_id = studentFactory.dataStudentDetail.data_student.id;
            $scope.loadingSupp = false;
            return $scope.student;
        });
    }

    //##############################//
    //      FUNGSI FILTER DATA      //
    //##############################//
    $scope.filterData = function() {
        if ($scope.report.datestart == null || $scope.report.dateend == null) {
            toastr.error('Pilihan Tanggal masih kosong', 'Pencarian Gagal!');
            return true;
        } else {
            $scope.loading = true;
            var date_start = $scope.report.datestart != null ? $filter('date')($scope.report.datestart, 'yyyy-MM-dd') : '';
            var date_end = $scope.report.dateend != null ? $filter('date')($scope.report.dateend, 'yyyy-MM-dd') : '';
            var student_id = $scope.report.student_id > 0 ? $scope.report.student_id : '';
            reportNewStudentsFactory.filterDataReportNewStudents(date_start, date_end, student_id)
            .then(function() {
                $scope.data = reportNewStudentsFactory.resultData;
                $scope.totalItems = reportNewStudentsFactory.totalItems;
                $scope.totalNewStudents = reportNewStudentsFactory.totalNewStudents;
                $scope.totalReturnSales = reportNewStudentsFactory.totalReturnSales;
                console.log($scope.data);
                $scope.loading = false;
            });
        }
    }

    //##############################//
    //       FUNGSI SORT DATA       //
    //##############################//
    $scope.sortColumn = "code";
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
        var date_start = $scope.report.datestart != null ? $filter('date')($scope.report.datestart, 'yyyy-MM-dd') : '';
        var date_end = $scope.report.dateend != null ? $filter('date')($scope.report.dateend, 'yyyy-MM-dd') : '';
        var student_id = $scope.report.student_id > 0 ? $scope.report.student_id : '';

        if ($scope.report.datestart == null || $scope.report.dateend == null) {
            toastr.error('Pilihan Tanggal masih kosong', 'Pencarian Gagal!');
            return true;
        } else {
            var url = 'reportNewStudents/exportExcel?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end;
            $window.open(url);
            $scope.loading = false;
        }
    }
})
