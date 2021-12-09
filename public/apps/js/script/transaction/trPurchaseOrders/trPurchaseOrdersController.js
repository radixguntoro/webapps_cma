var app = angular.module('trPurchaseOrdersCtrl', ['factoryTrPurchaseOrders']);

app.controller('trPurchaseOrdersController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $filter, $parse, $state, $compile, toastr, hotkeys, trPurchaseOrdersFactory, itemFactory) {
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

    $scope.typing = "I";
    $scope.cart = {};
    $scope.cart_purchases = {};
    $scope.cart_subtotal = 0;
    $scope.tr_purchases = {
        invoice: ''
        , date: $filter('date')(new Date(), 'yyyy-MM-dd')
        , total_price: 0
        , discount: 0
        , ppn: 0
        , grand_total: 0
    };

    $scope.checkPpn = false;

    $scope.dateOptions = {
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    };

    //##############################//
    //       GENERATE INVOICE       //
    //##############################//
    // $scope.genderateinvoice = function () {
    //     $scope.tr_purchases.invoice = "PC" + $filter('date')(new Date(), 'yy') + $filter('date')(new Date(), 'MM') + $filter('date')(new Date(), 'dd') + $filter('date')(new Date(), 'hh') + $filter('date')(new Date(), 'mm') + $filter('date')(new Date(), 'ss');
    // }

    // $scope.genderateinvoice();

    //##############################//
    //      MENAMBAH DATA CART      //
    //##############################//
    $scope.cartAdd = function(input) {
        angular.element('#search-tr-purchase-order').val('');
        trPurchaseOrdersFactory.addCart({
            item: input
        }).then(function() {
            $scope.tr_purchases.total_price= 0;
            $scope.tr_purchases.ppn= 0;
            $scope.tr_purchases.grand_total= 0;
        });
    }

    $scope.cart_item = [];
    $scope.itemAdd = function(input) {
        console.log(input);
        angular.element('#search-tr-purchase-order').val('');
        trPurchaseOrdersFactory.getDataItem({
            item_id: input.id
        }).then(function() {
            $scope.get_item = trPurchaseOrdersFactory.resDataItem;
			console.log("data", $scope.get_item);
            $scope.cart_item.push({
                "item_id": $scope.get_item.id
                , "name": $scope.get_item.name
                , "price_buy": $scope.get_item.price_buy
                , "price_sell": $scope.get_item.price_sell
                , "qty": 1
                , "qty_bonus": 0
                , "discount": $scope.get_item.price_sell > 0 ? ($scope.get_item.price_sell - $scope.get_item.price_buy) / $scope.get_item.price_sell : 1
                , "subtotal": $scope.get_item.price_buy * 1
            });
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        });
    }

    //##############################//
    //     MENGHAPUS DATA CART      //
    //##############################//
    $scope.cartRemove = function(elm) {
        $scope.cart_item.splice(elm.$index, 1);
        $scope.calcDiscAll();
        $scope.calcTotalPrice();
    }

    //##############################//
    //   MENGHAPUS DATA CART EDIT   //
    //##############################//
    $scope.cartEditRemove = function(elm, input) {
        $scope.tr_purchases.total_price= 0;
        $scope.tr_purchases.ppn= 0;
        $scope.tr_purchases.grand_total= 0;
        $scope.tr_purchases_detail.splice(elm.$index, 1);
        $scope.calcGrandTotalEdit();
    }

    //##############################//
    //    PERHITUNGAN PEMBELIAN     //
    //##############################//
    $scope.calcTotalPrice = function(elm) {
        var index = 0;
        var total_price_item = 0;
        var grand_total_item = 0;
        var total_disc_item = 0;
        angular.forEach($scope.cart_item, function(val, key) {
            total_price_item += (parseInt(val.price_buy) * parseInt(val.qty));
            grand_total_item += parseInt(val.subtotal);
            total_disc_item += (parseInt(val.subtotal) * parseInt(val.discount));
            // $scope.data_item[index] = val;
            // index += 1;
        });

        $scope.tr_purchases.total_price = total_price_item;
        $scope.tr_purchases.grand_total = grand_total_item;
    }

    // Kalkulasi Quantity
    $scope.calcQty = function(elm) {
        if (elm.cart.qty == null | elm.cart.qty == 0) {
            elm.cart.qty = 1;
            elm.cart.subtotal = parseInt(elm.cart.price_buy) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        } else {
            elm.cart.subtotal = parseInt(elm.cart.price_buy) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        }
    };


    // Kalkulasi Discount
    $scope.calcDiscAll = function(elm) {
        var index = 0;

        var total_disc_item = 0;
        $scope.disc_item = [];
        angular.forEach($scope.cart_item, function(val, key) {
            total_disc_item += ((parseInt(val.price_sell) * val.discount) * parseInt(val.qty));
        });

        $scope.tr_purchases.discount = total_disc_item;
    };

    //###############################//
    //  PENCARIAN ALL DATA BARANG   //
    //##############################//
    $scope.searchItem = function(typo, response) {
        itemFactory.searchItemManual({
            typo: typo.term
        }).then(function() {
            $scope.data_item = itemFactory.resSearchItem;
            if ($scope.data_item.length > 0) {
                response($scope.data_item);
            } else {
                response([{id: "0", name: "Data was not found"}]);
            }
        });
    };

    //##############################//
    //       FUNGSI CREATE DATA       //
    //##############################//

    $scope.createData = function(input) {
        if ($scope.tr_purchases.invoice == '') {
            toastr.error('Invoice number is required', 'Failed!');
            return true;
        } else {
            $scope.loading = true;
            angular.element('#btn-save').attr('disabled', true);
            trPurchaseOrdersFactory.insertDataTrPurchaseOrders({
                tr_purchases: $scope.tr_purchases,
                cart_item: $scope.cart_item,
            }).then(function() {
                var validation = trPurchaseOrdersFactory.resultInsert;
                if (validation == 'invalid') {
                    $scope.loading = false;
                    toastr.error('Invoice number has been used', 'Failed!');
                    angular.element('#btn-save').attr('disabled', false);
                    return;
                } else {
                    angular.element('#search-tr-purchase-order').val('');
                    angular.element('#btn-save').attr('disabled', false);
                    $state.reload();
                    $scope.tr_purchases = {
                        invoice: ''
                        , date: $filter('date')(new Date(), 'yyyy-MM-dd')
                        , total_price: 0
                        , discount: 0
                        , ppn: 0
                        , grand_total: 0
                    };
                    $scope.loading = false;
                    toastr.success('Data has been saved', 'Success!');
                }
            });
        }
    }

    //##############################//
    //        FUNGSI EDIT DATA        //
    //##############################//
    if ($state.current.name == "tr-purchases-order-edit") {
        // console.log($stateParams.id);
        $scope.tr_purchases = {};
        $scope.tr_purchases_cart = {};
        trPurchaseOrdersFactory.getDataEachTrPurchaseOrders($stateParams.id)
            .then(function() {
                $scope.tr_purchases = trPurchaseOrdersFactory.dataTrPurchaseOrders;
                $scope.tr_purchases_detail = trPurchaseOrdersFactory.dataTrPurchaseOrdersDetail;
            });

        $scope.updateData = function() {
            $scope.loading = true;
            angular.element('#btn-save').attr('disabled', true);
            trPurchaseOrdersFactory.updateDataTrPurchaseOrders({
                id: $stateParams.id,
                tr_purchases: $scope.tr_purchases,
                tr_purchases_cart: $scope.tr_purchases_detail,
                cart: $scope.data_cart,
            }).then(function() {
                angular.element('#btn-save').attr('disabled', false);
                $state.reload();
                $state.go("rep-trans-purchases");
                $scope.loading = false;
            });
        }
    }
})
