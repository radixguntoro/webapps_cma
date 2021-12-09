var app = angular.module('tuitionCtrl', ['factoryTuition']);

app.controller('tuitionController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, toastr, hotkeys, tuitionFactory, categoryFactory) {
    //##############################//
    //      DEKLARASI VARIABLE      //
    //##############################//
    $rootScope.$state = $state;

    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalTuitionsTemp = {};
    $scope.totalTuitions = 0;
    $scope.pagination = {
        current: 1
    };

    $scope.tuition = {
        name : ""
        , price : "0"
    };
    $scope.status = 'A';

    //##############################//
    //  LIST, PAGINATION & SEARCH   //
    //##############################//
    $scope.getResultsPage = function(pageNumber) {
        $scope.loading = true;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            tuitionFactory.searchDataTuition(pageNumber, $scope.searchText)
                .then(function() {
                    $scope.data = tuitionFactory.resultData;
                    $scope.totalTuitions = tuitionFactory.totalTuitions;
                    $scope.loading = false;
                });
        } else {
            tuitionFactory.getDataTuition(pageNumber)
                .then(function() {
                    $scope.data = tuitionFactory.resultData;
                    $scope.totalTuitions = tuitionFactory.totalTuitions;
                    $scope.loading = false;
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
                $scope.totalTuitionsTemp = $scope.totalTuitions;
                $scope.data = {};
            }
            $scope.getResultsPage(1);
        } else {
            if (!$.isEmptyObject($scope.libraryTemp)) {
                $scope.data = $scope.libraryTemp;
                $scope.totalTuitions = $scope.totalTuitionsTemp;
                $scope.libraryTemp = {};
                $scope.getResultsPage(1);
            }
        }
    }

    //##############################//
    //      FUNGSI CREATE DATA      //
    //##############################//
    $scope.createData = function() {
        if ($scope.tuition.name == null) {
            toastr.error('Tuition name is required', 'Failed!');
            return true;
        } else {
            angular.element('#btn-save').attr('disabled', true);
            tuitionFactory.insertDataTuition({
                tuition: {
                    name: $scope.tuition.name,
                    price: $scope.tuition.price
                },
                status: $scope.status
            }).then(function() {
                $state.go("tuition-list");
                angular.element('#btn-save').attr('disabled', false);
                angular.element('#inp-search').focus();
            });
        }
    }

    //##############################//
    //       FUNGSI EDIT DATA       //
    //##############################//
    if ($state.current.name == "tuition-edit") {
        tuitionFactory.getDataEachTuition($stateParams.id)
            .then(function() {
                $scope.tuition = tuitionFactory.eachDataTuition;
                $scope.status = itemFactory.eachDataTuition.status;
            });

        $scope.updateData = function() {
            if ($scope.tuition.name == null) {
                toastr.error('Tuition name is required', 'Failed!');
                return true;
            } else {
                angular.element('#btn-save').attr('disabled', true);
                tuitionFactory.updateDataTuition({
                    id: $stateParams.id,
                    tuition: {
                        name: $scope.tuition.name,
                        price: $scope.tuition.price
                    },
                    status: $scope.status,
                }).then(function() {
                    $state.go("tuition-list");
                    angular.element('#btn-save').attr('disabled', false);
                    angular.element('#inp-search').focus();
                });
            }
        }
    }

    //##############################//
    //       FUNGSI HAPUS DATA      //
    //##############################//
    $scope.deleteDataTuition = function(data) {
        tuitionFactory.deleteDataTuition({
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
    $scope.showTuitionDetail = function(tuition) {
        $scope.loadingDetail = true;
        tuitionFactory.showTuitionDetail({
            tuition_id: tuition.id
        }).then(function() {
            $scope.tuition_detail = tuitionFactory.dataTuitionDetail.data_tuition;
            $scope.loadingDetail = false;
        });
    }

    //##############################//
    //    HOTKEYS FORM PENJUALAN    //
    //##############################//
    if ($state.current.name == 'tuition-list') {
        $scope.helpShow = false;
        $scope.helpPanel = function(flag) {
            if (flag) {
                $scope.helpShow = false;
            } else {
                $scope.helpShow = true;
            }
        }
        angular.element('#inp-search').focus();
        hotkeys.add({
            combo: 'alt+h',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $timeout(function() {
                    angular.element('#btn-help').triggerHandler('click');
                }, 0);
            }
        });

        hotkeys.add({
            combo: 'alt+t',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $state.go('tuition-create');
            }
        });

        hotkeys.add({
            combo: 'alt+f',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                angular.element('#inp-search').focus();
            }
        });

        return true;
    }

    if ($state.current.name == 'tuition-create') {
        $scope.helpShow = false;
        $scope.helpPanel = function(flag) {
            if (flag) {
                $scope.helpShow = false;
            } else {
                $scope.helpShow = true;
            }
        }
        hotkeys.add({
            combo: 'alt+h',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $timeout(function() {
                    angular.element('#btn-help').triggerHandler('click');
                }, 0);
            }
        });
        angular.element('#barcode-box').focus();
        hotkeys.add({
            combo: 'ctrl+d',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                angular.element('#barcode-box').focus();
                return true;
            }
        });
        hotkeys.add({
            combo: 'alt+d',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                angular.element('#barcode-strip').focus();
                return true;
            }
        });
        hotkeys.add({
            combo: 'alt+s',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                if ($scope.loading == true) {
                    return true;
                } else {
                    $scope.createData();
                }
            }
        });
        hotkeys.add({
            combo: 'esc',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $state.go('tuition-list');
            }
        });
        return true;
    }

    if ($state.current.name == "tuition-edit") {
        angular.element('#barcode-box').focus();
        $scope.helpShow = false;
        $scope.helpPanel = function(flag) {
            if (flag) {
                $scope.helpShow = false;
            } else {
                $scope.helpShow = true;
            }
        }
        hotkeys.add({
            combo: 'alt+h',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $timeout(function() {
                    angular.element('#btn-help').triggerHandler('click');
                }, 0);
            }
        });
        hotkeys.add({
            combo: 'ctrl+d',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                angular.element('#barcode-box').focus();
                return true;
            }
        });
        hotkeys.add({
            combo: 'alt+d',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                angular.element('#barcode-strip').focus();
                return true;
            }
        });
        hotkeys.add({
            combo: 'alt+s',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                if ($scope.loading == true) {
                    return true;
                } else {
                    $scope.updateData();
                }
            }
        });
        hotkeys.add({
            combo: 'esc',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $state.go('tuition-list');
            }
        });
        return true;
    }
})
