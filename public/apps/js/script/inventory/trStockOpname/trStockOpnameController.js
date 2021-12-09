var app = angular.module('trStockOpnameCtrl', ['factoryTrStockOpname']);

app.controller('trStockOpnameController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $filter, $parse, $state, $compile, toastr, hotkeys, trStockOpnameFactory, itemFactory) {
    //##############################//
    //      DEKLARASI VARIABLE      //
    //##############################//
    $rootScope.$state = $state;
    // Deklarasi StockOpname List
    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalItemsTemp = {};
    $scope.totalItems = 0;
    $scope.pagination = {
        current: 1
    };

    $scope.tr_stock_opname = {};
    $scope.tr_stock_opname = {
        date: $filter('date')(new Date(), 'dd MMM yyyy'),
        price_sell_phx: 0,
        price_sell_difference: 0,
        stock_difference: 0,
        stock_in_physic: 0,
    }

    $scope.tr_stock_opname.price_sell_physic = 0;

    $scope.generateId = function() {
        $scope.tr_stock_opname.code= $filter('date')(new Date(), 'yy') + $filter('date')(new Date(), 'MM') + $filter('date')(new Date(), 'yy') + $filter('date')(new Date(), 'dd') + $filter('date')(new Date(), 'hh')+$filter('date')(new Date(), 'mm') + $filter('date')(new Date(), 'ss');
    }

    $scope.generateId();

    //############################## //
    //  PERHITUNGAN PENYAMAAN STOCK  //
    //############################## //
    $scope.validQty = function(elm) {
        console.log(elm);
        if (elm.stock_opname.stock_in_physic == null) {
            elm.stock_opname.stock_in_physic = '';
            elm.stock_opname.stock_difference = 0;
            elm.stock_opname.price_sell_difference = 0;
            elm.stock_opname.price_sell_phx = 0;
        } else {
            elm.stock_opname.stock_difference = elm.stock_opname.stock_in_physic - elm.stock_opname.stock_in_system;
            elm.stock_opname.price_sell_difference = elm.stock_opname.stock_difference * elm.stock_opname.price_sell_app;
            elm.stock_opname.price_sell_phx = elm.stock_opname.stock_in_physic * elm.stock_opname.price_sell;
        }

    };

    //##############################//
    //  LIST, PAGINATION & SEARCH   //
    //##############################//
    $scope.getResultsPage = function(pageNumber) {
        $scope.loading = true;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            trStockOpnameFactory.searchDataTrStockOpname(pageNumber, $scope.searchText)
                .then(function() {
                    $scope.data = trStockOpnameFactory.resultData;
                    $scope.totalItems = trStockOpnameFactory.totalItems;
                    $scope.loading = false;
                });
        } else {
            trStockOpnameFactory.getDataTrStockOpname(pageNumber)
                .then(function() {
                    $scope.data = trStockOpnameFactory.resultData;
                    $scope.totalItems = trStockOpnameFactory.totalItems;
                    $scope.loading = false;
                });
        }
    }

    $scope.pageChanged = function(newPage) {
        $scope.getResultsPage(newPage);
    };

    $scope.getResultsPage(1);

    $scope.searchItem = function(typo, response) {
        itemFactory.searchItemAll({
            typo: typo.term
        }).then(function() {
            $scope.data_item = itemFactory.resSearchItemAll;
            if ($scope.data_item.length > 0) {
                response($scope.data_item);
            } else {
                response([{id: "0", name: "Maaf, data tidak ditemukan"}]);
            }
        });
    };

    //##############################//
    //       ADD STOCK OPNAME       //
    //##############################//
    $scope.cart_item = [];
    $scope.trStockOpnameAdd = function(input) {
        angular.element('#search-stock-opname').val('');
        trStockOpnameFactory.getDataItem({
            tr_stock_opname: input
        }).then(function() {
            $scope.get_item = trStockOpnameFactory.resDataItem;
            console.log($scope.get_item);
            $scope.cart_item.push({
                "item_id": $scope.get_item.code,
                "name": $scope.get_item.name,
                "price_purchase_app": 0,
                "price_purchase_phx": 0,
                "price_purchase_difference": 0,
                "price_sell_app": $scope.get_item.price_sell,
                "price_sell_phx": 0,
                "price_sell_difference": 0,
                "stock_in_system": $scope.get_item.qty,
                "stock_in_phx": 0,
                "stock_difference": 0,
                "category": $scope.get_item.category,
            });
            console.log($scope.cart_item);
        });
    }

    $scope.cartRemoveItem = function(elm, input) {
        $scope.cart_item.splice(elm.$index, 1);
    }

    //##############################//
    //      CREATE STOCK OPNAME     //
    //##############################//
    $scope.createData = function(data) {
        var temp = [];
        angular.forEach(data, function(val, key) {
            if (val.stock_in_physic == null) {
                temp[key] = val.stock_in_physic;
            }
        });
        if (data == '') {
            toastr.error('Data is empty', 'Failed!');
            return true;
        } else if(angular.fromJson(temp).length > 0) {
            toastr.error('Physical stock incomplete', 'Failed!');
            return true;
        } else {
            $scope.loading = true;
            trStockOpnameFactory.createData({
                cart_item: data
            }).then(function() {
                $scope.cart_item = [];
                $scope.loading = false;
            });
        }
    }

    $scope.editTrStockOpname = function(data) {
        $scope.loading = true;
        trStockOpnameFactory.editDataStockOpname({
            tr_stock_opname: data
        }).then(function() {
            $scope.getResultsPage(1);
            $scope.generateId();
        });
    }

    //##############################//
    //      DELETE STOCK OPNAME     //
    //##############################//
    $scope.deleteTrStockOpname = function(data) {
        $scope.loading = true;
        trStockOpnameFactory.deleteDataTrStockOpname({
            tr_stock_opname: data
        }).then(function() {
            $scope.getResultsPage(1);
            $scope.generateId();
        });
    }
})
