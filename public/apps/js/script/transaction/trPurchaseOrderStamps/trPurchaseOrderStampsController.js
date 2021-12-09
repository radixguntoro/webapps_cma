var app = angular.module('trPurchaseOrderStampsCtrl', ['factoryTrPurchaseOrderStamps']);

app.controller('trPurchaseOrderStampsController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $filter, $parse, $state, $compile, toastr, hotkeys, trPurchaseOrderStampsFactory, stampFactory) {
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
        angular.element('#search-tr-purchase-order-stamp').val('');
        trPurchaseOrderStampsFactory.addCart({
            stamp: input
        }).then(function() {
            $scope.tr_purchases.total_price= 0;
            $scope.tr_purchases.ppn= 0;
            $scope.tr_purchases.grand_total= 0;
        });
    }

    $scope.cart_stamp = [];
    $scope.stampAdd = function(input) {
        console.log(input);
        angular.element('#search-tr-purchase-order-stamp').val('');
        trPurchaseOrderStampsFactory.getDataStamp({
            stamp_id: input.id
        }).then(function() {
            $scope.get_stamp = trPurchaseOrderStampsFactory.resDataStamp;
			console.log("data", $scope.get_stamp);
            $scope.cart_stamp.push({
                "stamp_id": $scope.get_stamp.id
                , "name": $scope.get_stamp.name
                , "price_buy": $scope.get_stamp.price
                , "qty": 1
                , "discount": 0
                , "subtotal": $scope.get_stamp.price
            });
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        });
    }

    //##############################//
    //     MENGHAPUS DATA CART      //
    //##############################//
    $scope.cartRemove = function(elm) {
        $scope.cart_stamp.splice(elm.$index, 1);
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
        var total_price_stamp = 0;
        var grand_total_stamp = 0;
        var total_disc_stamp = 0;
        angular.forEach($scope.cart_stamp, function(val, key) {
            total_price_stamp += (parseInt(val.price_buy) * parseInt(val.qty));
            grand_total_stamp += parseInt(val.subtotal);
            total_disc_stamp += (parseInt(val.subtotal) * parseInt(val.discount));
            // $scope.data_stamp[index] = val;
            // index += 1;
        });

        $scope.tr_purchases.total_price = total_price_stamp;
        $scope.tr_purchases.grand_total = grand_total_stamp;
    }

    // Kalkulasi Quantity
    $scope.calcQty = function(elm) {
        if (elm.cart.qty == null | elm.cart.qty == 0) {
            elm.cart.qty = 1;
            elm.cart.subtotal = (parseInt(elm.cart.price_buy) - parseInt(elm.cart.price_buy * elm.cart.discount)) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        } else {
            elm.cart.subtotal = (parseInt(elm.cart.price_buy) - parseInt(elm.cart.price_buy * elm.cart.discount)) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        }
    };

    // Kalkulasi Price Buy
    $scope.calcPriceBuy = function(elm) {
        if (elm.cart.price_buy == null | elm.cart.price_buy == 0) {
            elm.cart.price_buy = 0;
            elm.cart.subtotal = (parseInt(elm.cart.price_buy) - parseInt(elm.cart.price_buy * elm.cart.discount)) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        } else {
            elm.cart.subtotal = (parseInt(elm.cart.price_buy) - parseInt(elm.cart.price_buy * elm.cart.discount)) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        }
    };

    // Kalkulasi Discount
    $scope.calcDiscAll = function(elm) {
        var index = 0;

        var total_disc_stamp = 0;
        $scope.disc_stamp = [];
        angular.forEach($scope.cart_stamp, function(val, key) {
            total_disc_stamp += ((parseInt(val.price_buy) * val.discount) * parseInt(val.qty));
        });

        $scope.tr_purchases.discount = total_disc_stamp;
    };

    // Kalkulasi Disc Stamp
    $scope.calcDiscStamp = function(elm) {
        if (elm.cart.discount == null | elm.cart.discount == 0 | isNaN(elm.cart.discount)) {
            elm.cart.discount = 0;
            elm.cart.subtotal = (parseInt(elm.cart.price_buy) - parseInt(elm.cart.price_buy * elm.cart.discount)) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        } else if (elm.cart.discount > 0.9) {
            elm.cart.discount = 0;
            elm.cart.subtotal = (parseInt(elm.cart.price_buy) - parseInt(elm.cart.price_buy * elm.cart.discount)) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        } else if (elm.cart.discount > 0) {
            elm.cart.subtotal = (parseInt(elm.cart.price_buy) - parseInt(elm.cart.price_buy * elm.cart.discount)) * elm.cart.qty;
            $scope.calcDiscAll();
            $scope.calcTotalPrice();
        }
    };

    //###############################//
    //  PENCARIAN ALL DATA BARANG   //
    //##############################//
    $scope.searchStamp = function(typo, response) {
        stampFactory.searchStamp({
            typo: typo.term
        }).then(function() {
            $scope.data_stamp = stampFactory.resSearchStamp;
            if ($scope.data_stamp.length > 0) {
                response($scope.data_stamp);
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
            trPurchaseOrderStampsFactory.insertDataTrPurchaseOrderStamps({
                tr_purchases: $scope.tr_purchases,
                cart_stamp: $scope.cart_stamp,
            }).then(function() {
                var validation = trPurchaseOrderStampsFactory.resultInsert;
                if (validation == 'invalid') {
                    $scope.loading = false;
                    toastr.error('Invoice number has been used', 'Failed!');
                    angular.element('#btn-save').attr('disabled', false);
                    return;
                } else {
                    angular.element('#search-tr-purchase-order-stamp').val('');
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
        trPurchaseOrderStampsFactory.getDataEachTrPurchaseOrderStamps($stateParams.id)
            .then(function() {
                $scope.tr_purchases = trPurchaseOrderStampsFactory.dataTrPurchaseOrderStamps;
                $scope.tr_purchases_detail = trPurchaseOrderStampsFactory.dataTrPurchaseOrderStampsDetail;
            });

        $scope.updateData = function() {
            $scope.loading = true;
            angular.element('#btn-save').attr('disabled', true);
            trPurchaseOrderStampsFactory.updateDataTrPurchaseOrderStamps({
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
