var app = angular.module('studentCtrl', ['factoryStudent']);

app.controller('studentController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $filter, $state, toastr, hotkeys, studentFactory) {
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

    $scope.status = "A";
    $scope.student = {
        name: ''
        , deposit: 0
        , join_date: $filter('date')(new Date(), 'yyyy-MM-dd')
    };

    $scope.dateReportOptions = {
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    };

    $scope.validNumber = function(elm) {
        if (elm.student.deposit == '' || elm.student.deposit == null) {
            elm.student.deposit = 0;
        }
    }

    //##############################//
    //  LIST, PAGINATION & SEARCH   //
    //##############################//
    $scope.getResultsPage = function(pageNumber) {
        $scope.loading = true;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            studentFactory.searchDataStudent(pageNumber, $scope.searchText)
                .then(function() {
                    $scope.data = studentFactory.resultData;
                    $scope.totalItems = studentFactory.totalItems;
                    $scope.loading = false;
                });
        } else {
            studentFactory.getDataStudent(pageNumber)
                .then(function() {
                    $scope.data = studentFactory.resultData;
                    $scope.totalItems = studentFactory.totalItems;
                    $scope.loading = false;
                    console.log($scope.data);
                });
        }
    }

    $scope.pageChanged = function(newPage) {
        $scope.getResultsPage(newPage);
    };

    $scope.getResultsPage(1);

    $scope.searchData = function() {
        if ($scope.searchText.length >= 3) {
            if ($.isEmptyObject($scope.libraryTemp)) {
                $scope.libraryTemp = $scope.data;
                $scope.totalItemsTemp = $scope.totalItems;
                $scope.data = {};
            }
            $scope.getResultsPage(1);
        } else {
            if (!$.isEmptyObject($scope.libraryTemp)) {
                $scope.data = $scope.libraryTemp;
                $scope.totalItems = $scope.totalItemsTemp;
                $scope.libraryTemp = {};
                $scope.getResultsPage(1);
            }
        }
    }

    //##############################//
    //      FUNGSI CREATE DATA      //
    //##############################//
    $scope.createData = function() {
        $scope.loading = true;
        if ($scope.student.name == null) {
            toastr.error('Student name is required', 'Failed!');
            return true;
        } else {
            angular.element('#btn-save').attr('disabled', true);
            studentFactory.insertDataStudent({
                student: $scope.student,
                status: $scope.status,
            }).then(function() {
                var validation = studentFactory.resultInsert;
                if (validation == 'invalid') {
                    $scope.loading = false;
                    toastr.error('Code number has been used', 'Failed!');
                    angular.element('#btn-save').attr('disabled', false);
                    return;
                } else {
                    $state.go("student-list");
                    angular.element('#btn-save').attr('disabled', false);
                    $scope.loading = false;
                    toastr.success('Data has been saved', 'Success!');
                }
            });
        }
    }

    //##############################//
    //       FUNGSI EDIT DATA       //
    //##############################//
    if ($state.current.name == "student-edit") {
        $scope.student = {};
        studentFactory.getDataEachStudent($stateParams.id)
            .then(function() {
                $scope.student = studentFactory.eachDataStudent;
                $scope.status = studentFactory.eachDataStudent.status;
            });

        $scope.updateData = function() {
            $scope.loading = true;
            if ($scope.student.name == null) {
                toastr.error('Student name is required', 'Failed!');
                return true;
            } else {
                angular.element('#btn-save').attr('disabled', true);
                studentFactory.updateDataStudent({
                    id: $stateParams.id,
                    student: $scope.student,
                    status: $scope.status
                }).then(function() {
                    $state.go("student-list");
                    angular.element('#btn-save').attr('disabled', false);
                    $scope.loading = false;
                });
            }
        }
    }

    //##############################//
    //       FUNGSI HAPUS DATA      //
    //##############################//
    $scope.deleteDataStudent = function(data) {
        studentFactory.deleteDataStudent({
            id: data.id
        }).then(function() {
            $state.go($state.current, {}, {
                reload: true
            });
        });
    }

    //##############################//
    //      FUNGSI DETAIL DATA      //
    //##############################//
    $scope.showStudentDetail = function(student) {
        $scope.loadingDetail = true;
        studentFactory.showStudentDetail({
            student_id: student.id
        }).then(function() {
            $scope.student_detail = studentFactory.dataStudentDetail.data_student;
            console.log($scope.student_detail);
            $scope.loadingDetail = false;
        });
    }
})
