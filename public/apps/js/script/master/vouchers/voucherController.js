var app = angular.module('voucherCtrl', ['factoryVoucher']);

app.controller('voucherController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, toastr, hotkeys, voucherFactory, categoryFactory) {
    //##############################//
    //      DEKLARASI VARIABLE      //
    //##############################//
    $rootScope.$state = $state;

    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalVouchersTemp = {};
    $scope.totalVouchers = 0;
    $scope.pagination = {
        current: 1
    };

    $scope.voucher = {
        name : ""
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
            voucherFactory.searchDataVoucher(pageNumber, $scope.searchText)
                .then(function() {
                    $scope.data = voucherFactory.resultData;
                    $scope.totalVouchers = voucherFactory.totalVouchers;
                    $scope.loading = false;
                });
        } else {
            voucherFactory.getDataVoucher(pageNumber)
                .then(function() {
                    $scope.data = voucherFactory.resultData;
                    $scope.totalVouchers = voucherFactory.totalVouchers;
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
                $scope.totalVouchersTemp = $scope.totalVouchers;
                $scope.data = {};
            }
            $scope.getResultsPage(1);
        } else {
            if (!$.isEmptyObject($scope.libraryTemp)) {
                $scope.data = $scope.libraryTemp;
                $scope.totalVouchers = $scope.totalVouchersTemp;
                $scope.libraryTemp = {};
                $scope.getResultsPage(1);
            }
        }
    }

    //##############################//
    //      FUNGSI CREATE DATA      //
    //##############################//
    $scope.createData = function() {
        if ($scope.voucher.name == null) {
            toastr.error('Voucher name is required', 'Failed!');
            return true;
        } else {
            angular.element('#btn-save').attr('disabled', true);
            voucherFactory.insertDataVoucher({
                voucher: {
                    name: $scope.voucher.name,
                    price: $scope.voucher.price,
                    qty: $scope.voucher.qty,
                },
                status: $scope.status,
            }).then(function() {
                $state.go("voucher-list");
                angular.element('#btn-save').attr('disabled', false);
                angular.element('#inp-search').focus();
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
    if ($state.current.name == "voucher-edit") {
        voucherFactory.getDataEachVoucher($stateParams.id)
            .then(function() {
                $scope.voucher = voucherFactory.eachDataVoucher;
                $scope.status = voucherFactory.eachDataVoucher.status;
            });

        $scope.updateData = function() {
            if ($scope.voucher.name == null) {
                toastr.error('Voucher name is required', 'Failed!');
                return true;
            } else {
                angular.element('#btn-save').attr('disabled', true);
                voucherFactory.updateDataVoucher({
                    id: $stateParams.id,
                    voucher: {
                        name: $scope.voucher.name,
                        price: $scope.voucher.price,
                        qty: $scope.voucher.qty,
                    },
                    status: $scope.status,
                }).then(function() {
                    $state.go("voucher-list");
                    angular.element('#btn-save').attr('disabled', false);
                    angular.element('#inp-search').focus();
                });
            }
        }
    }

    //##############################//
    //       FUNGSI HAPUS DATA      //
    //##############################//
    $scope.deleteDataVoucher = function(data) {
        voucherFactory.deleteDataVoucher({
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
    $scope.showVoucherDetail = function(voucher) {
        $scope.loadingDetail = true;
        voucherFactory.showVoucherDetail({
            voucher_id: voucher.id
        }).then(function() {
            $scope.voucher_detail = voucherFactory.dataVoucherDetail.data_voucher;
            $scope.loadingDetail = false;
        });
    }

    //##############################//
    //    HOTKEYS FORM PENJUALAN    //
    //##############################//
    if ($state.current.name == 'voucher-list') {
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
                $state.go('voucher-create');
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

    if ($state.current.name == 'voucher-create') {
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
                $state.go('voucher-list');
            }
        });
        return true;
    }

    if ($state.current.name == "voucher-edit") {
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
                $state.go('voucher-list');
            }
        });
        return true;
    }
})
