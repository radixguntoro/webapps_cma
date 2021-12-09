var app = angular.module('itemCtrl', ['factoryItem']);

app.controller('itemController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, toastr, hotkeys, itemFactory, categoryFactory) {
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

    $scope.item = {
        price_buy : 0
        , price_sell : 0
        , price_starter_kids : 0
        , qty : 0
    };

    $scope.status = 'A';
    $scope.starter_kids = 'N';

    //##############################//
    //  LIST, PAGINATION & SEARCH   //
    //##############################//
    $scope.getResultsPage = function(pageNumber) {
        $scope.loading = true;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            itemFactory.searchDataItem(pageNumber, $scope.searchText)
                .then(function() {
                    $scope.data = itemFactory.resultData;
                    $scope.totalItems = itemFactory.totalItems;
                    $scope.loading = false;
                });
        } else {
            itemFactory.getDataItem(pageNumber)
                .then(function() {
                    $scope.data = itemFactory.resultData;
                    $scope.totalItems = itemFactory.totalItems;
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
        if ($scope.item.name == null) {
            toastr.error('Item name is required', 'Failed!');
            return true;
        } else {
            angular.element('#btn-save').attr('disabled', true);
            itemFactory.insertDataItem({
                item: {
                    name: $scope.item.name,
                    price_buy: $scope.item.price_buy,
                    price_sell: $scope.item.price_sell,
                    price_starter_kids: $scope.item.price_starter_kids,
                    qty: $scope.item.qty,
                },
                category_id: $scope.category.id,
                status: $scope.status,
                starter_kids: $scope.starter_kids,
            }).then(function() {
                var validation = itemFactory.resultInsert;
                if (validation == 'invalid') {
                    $scope.loading = false;
                    toastr.error('Item name has been used', 'Failed!');
                    angular.element('#btn-save').attr('disabled', false);
                    return;
                } else {
                    $state.go("item-list");
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
    if ($state.current.name == "item-edit") {
        itemFactory.getDataEachItem($stateParams.id)
            .then(function() {
                $scope.item = itemFactory.eachDataItem;
                $scope.status = itemFactory.eachDataItem.status;
                $scope.starter_kids = itemFactory.eachDataItem.starter_kids;
                $scope.category_id = itemFactory.eachDataItem.category_id;
                categoryFactory.getAllDataCategory()
                    .then(function() {
                        $scope.categories = categoryFactory.allDataCategory;
                        angular.forEach($scope.categories, function(value, key){
                            if(value.id == $scope.category_id) {
                                $scope.category = value;
                            }
                        });
                    });
            });

        $scope.updateData = function() {
            if ($scope.item.name == null) {
                toastr.error('Item name is required', 'Failed!');
                return true;
            } else {
                angular.element('#btn-save').attr('disabled', true);
                itemFactory.updateDataItem({
                    id: $stateParams.id,
                    item: {
                        name: $scope.item.name,
                        price_buy: $scope.item.price_buy,
                        price_sell: $scope.item.price_sell,
                        price_starter_kids: $scope.item.price_starter_kids,
                        qty: $scope.item.qty,
                    },
                    category_id: $scope.category.id,
                    status: $scope.status,
                    starter_kids: $scope.starter_kids,
                }).then(function() {
                    $state.go("item-list");
                    angular.element('#btn-save').attr('disabled', false);
                    angular.element('#inp-search').focus();
                });
            }
        }
    }

    //##############################//
    //       FUNGSI HAPUS DATA      //
    //##############################//
    $scope.deleteDataItem = function(data) {
        itemFactory.deleteDataItem({
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
    $scope.showItemDetail = function(item) {
        $scope.loadingDetail = true;
        itemFactory.showItemDetail({
            item_id: item.id
        }).then(function() {
            $scope.item_detail = itemFactory.dataItemDetail.data_item;
            $scope.loadingDetail = false;
        });
    }

    //##############################//
    //    HOTKEYS FORM PENJUALAN    //
    //##############################//
    if ($state.current.name == 'item-list') {
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
                $state.go('item-create');
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

    if ($state.current.name == 'item-create') {
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
                $state.go('item-list');
            }
        });
        return true;
    }

    if ($state.current.name == "item-edit") {
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
                $state.go('item-list');
            }
        });
        return true;
    }
})
