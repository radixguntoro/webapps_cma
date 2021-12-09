var app = angular.module('stampCtrl', ['factoryStamp']);

app.controller('stampController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, toastr, hotkeys, stampFactory, categoryFactory) {
    //##############################//
    //      DEKLARASI VARIABLE      //
    //##############################//
    $rootScope.$state = $state;

    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalStampsTemp = {};
    $scope.totalStamps = 0;
    $scope.pagination = {
        current: 1
    };

    $scope.stamp = {
        name : ""
        , stamp : 0
        , price : 0
        , qty : 0
    };
    $scope.status = 'A';

    //##############################//
    //  LIST, PAGINATION & SEARCH   //
    //##############################//
    $scope.getResultsPage = function(pageNumber) {
        $scope.loading = true;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            stampFactory.searchDataStamp(pageNumber, $scope.searchText)
                .then(function() {
                    $scope.data = stampFactory.resultData;
                    $scope.totalStamps = stampFactory.totalStamps;
                    $scope.loading = false;
                });
        } else {
            stampFactory.getDataStamp(pageNumber)
                .then(function() {
                    $scope.data = stampFactory.resultData;
                    $scope.totalStamps = stampFactory.totalStamps;
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
                $scope.totalStampsTemp = $scope.totalStamps;
                $scope.data = {};
            }
            $scope.getResultsPage(1);
        } else {
            if (!$.isEmptyObject($scope.libraryTemp)) {
                $scope.data = $scope.libraryTemp;
                $scope.totalStamps = $scope.totalStampsTemp;
                $scope.libraryTemp = {};
                $scope.getResultsPage(1);
            }
        }
    }

    //##############################//
    //      FUNGSI CREATE DATA      //
    //##############################//
    $scope.createData = function() {
        if ($scope.stamp.name == null) {
            toastr.error('Item name is required', 'Failed!');
            return true;
        } else {
            angular.element('#btn-save').attr('disabled', true);
            stampFactory.insertDataStamp({
                stamp: {
                    name: $scope.stamp.name,
                    stamp: $scope.stamp.stamp,
                    price: $scope.stamp.price,
                    qty: $scope.stamp.qty,
                },
                category_id: $scope.category.id,
                status: $scope.status,
            }).then(function() {
                var validation = stampFactory.resultInsert;
                if (validation == 'invalid') {
                    $scope.loading = false;
                    toastr.error('Item name has been used', 'Failed!');
                    angular.element('#btn-save').attr('disabled', false);
                    return;
                } else {
                    $state.go("stamp-list");
                    angular.element('#btn-save').attr('disabled', false);
                    $scope.loading = false;
                    toastr.success('Data has been saved', 'Success!');
                }
            });
        }
    }

    //##############################//
    //  MENAMPILKAN DATA KATEGORI   //
    //##############################//
    categoryFactory.getAllDataCategory()
        .then(function() {
            $scope.categories = categoryFactory.allDataCategory;
            $scope.category = categoryFactory.allDataCategory[0];
            console.log($scope.category);
        });

    //##############################//
    //       FUNGSI EDIT DATA       //
    //##############################//
    if ($state.current.name == "stamp-edit") {
        stampFactory.getDataEachStamp($stateParams.id)
            .then(function() {
                $scope.stamp = stampFactory.eachDataStamp;
                $scope.status = stampFactory.eachDataStamp.status;
            });

        $scope.updateData = function() {
            if ($scope.stamp.name == null) {
                toastr.error('Item name is required', 'Failed!');
                return true;
            } else {
                angular.element('#btn-save').attr('disabled', true);
                stampFactory.updateDataStamp({
                    id: $stateParams.id,
                    stamp: {
                        name: $scope.stamp.name,
                        stamp: $scope.stamp.stamp,
                        price: $scope.stamp.price,
                        qty: $scope.stamp.qty,
                    },
                    category_id: $scope.category.id,
                    status: $scope.status,
                }).then(function() {
                    $state.go("stamp-list");
                    angular.element('#btn-save').attr('disabled', false);
                    angular.element('#inp-search').focus();
                });
            }
        }
    }

    //##############################//
    //       FUNGSI HAPUS DATA      //
    //##############################//
    $scope.deleteDataStamp = function(data) {
        stampFactory.deleteDataStamp({
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
    $scope.showStampDetail = function(stamp) {
        $scope.loadingDetail = true;
        stampFactory.showStampDetail({
            stamp_id: stamp.id
        }).then(function() {
            $scope.stamp_detail = stampFactory.dataStampDetail.data_stamp;
            $scope.loadingDetail = false;
        });
    }

    //##############################//
    //    HOTKEYS FORM PENJUALAN    //
    //##############################//
    if ($state.current.name == 'stamp-list') {
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
                $state.go('stamp-create');
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

    if ($state.current.name == 'stamp-create') {
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
                $state.go('stamp-list');
            }
        });
        return true;
    }

    if ($state.current.name == "stamp-edit") {
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
                $state.go('stamp-list');
            }
        });
        return true;
    }
})
