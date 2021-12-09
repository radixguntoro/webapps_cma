var app = angular.module('reportTrChangeBooksCtrl', ['factoryReportTrChangeBooks']);

app.controller('reportTrChangeBooksController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, $filter, toastr, hotkeys, reportTrChangeBooksFactory, studentFactory) {
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

    $scope.validStudent = function(elm) {
        $scope.report.student_id = '';
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
            reportTrChangeBooksFactory.filterDataReportTrChangeBooks(date_start, date_end, student_id)
            .then(function() {
                $scope.data = reportTrChangeBooksFactory.resultData;
                $scope.totalItems = reportTrChangeBooksFactory.totalItems;
                $scope.totalTrChangeBooks = reportTrChangeBooksFactory.totalTrChangeBooks;
                $scope.totalReturnSales = reportTrChangeBooksFactory.totalReturnSales;
                console.log($scope.data);
                $scope.loading = false;
            });
        }
    }

    //##############################//
    //       FUNGSI SORT DATA       //
    //##############################//
    $scope.sortColumn = "";
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
        var student_id = $scope.report.student_id > 0 ? $scope.report.student_id : '';

        if ($scope.report.datestart == null || $scope.report.dateend == null) {
            toastr.error('Pilihan Tanggal masih kosong', 'Pencarian Gagal!');
            return true;
        } else {
            var url = 'reportTrChangeBooks/exportExcel?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end;
            $window.open(url);
            $scope.loading = false;
        }
    }

    //##############################//
    //    MENAMPILKAN DETIL DATA    //
    //##############################//
    $scope.showTrChangeBooksDetail = function(tr_change_books) {
        $scope.loadingDetail = true;
        reportTrChangeBooksFactory.showTrChangeBooksDetail({
            tr_change_books_id: tr_change_books.id
        }).then(function() {
            $scope.tr_change_book_item_detail = reportTrChangeBooksFactory.dataTrChangeBooksDetail.tr_change_book_item_detail;
            $scope.tr_change_book_tuition_detail = reportTrChangeBooksFactory.dataTrChangeBooksDetail.tr_change_book_tuition_detail;
            $scope.tr_change_book_deposit_detail = reportTrChangeBooksFactory.dataTrChangeBooksDetail.tr_change_book_deposit_detail;
            $scope.loadingDetail = false;
        });
    }
})
