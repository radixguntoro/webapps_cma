var app = angular.module('trPaymentsCtrl', ['factoryTrPayments']);

app.controller('trPaymentsController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $filter, $parse, $state, $compile, toastr, hotkeys, trPaymentsFactory, studentFactory, tuitionFactory, itemFactory, voucherFactory) {

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

    $scope.student = {
        name: ''
        , code: ''
        , deposit: ''
    };

    $scope.tr_payments = {
        invoice: '',
        total_price: 0,
        discount: 0,
        grand_total: 0,
        payment: 0,
        cash: 0,
        debit: 0,
        transfer: 0,
        total_method: 0,
        deposit_total: 0,
        deposit_discount: 0,
        deposit_subtotal: 0,
        balance: 0,
        date: $filter('date')(new Date(), 'yyyy-MM-dd')
    };

    $scope.dateOptions = {
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    };

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
                response([{id: "0", name: "Data was not found"}]);
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
            $scope.student = {
                code: studentFactory.dataStudentDetail.data_student.code
                , id: studentFactory.dataStudentDetail.data_student.id
                , name : studentFactory.dataStudentDetail.data_student.name
                , deposit : studentFactory.dataStudentDetail.data_student.deposit
            }
            $scope.loadingSupp = false;
            return $scope.student;
        });
    }

    //##############################//
    //      PENCARIAN TUITION      //
    //##############################//
    $scope.searchTuition = function(typo, response) {
        tuitionFactory.searchTuitionManual({
            typo: typo.term
        }).then(function() {
            $scope.data_tuition = tuitionFactory.resSearchTuition;
            if ($scope.data_tuition.length > 0) {
                response($scope.data_tuition);
            } else {
                response([{id: "0", name: "Data was not found"}]);
            }
        });
    };

    //##############################//
    //      PENCARIAN ITEM      //
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
    //  MENAMPILKAN DATA VOUCHER    //
    //##############################//
    voucherFactory.getAllDataVoucher()
        .then(function() {
            $scope.vouchers_all = voucherFactory.allDataVoucher;
            $scope.vouchers = [{
                id: 0,
                name: "-- Choose Voucher --",
                price: 0,
            }];
            angular.forEach($scope.vouchers_all, function(value, key){
                $scope.vouchers.push(value);
            });
            $scope.tr_payments.voucher = $scope.vouchers[0];
        });

    //##############################//
    //    PERHITUNGAN PENJUALAN     //
    //##############################//
    $scope.calcTotalPrice = function(elm) {
        $scope.tr_payments.deposit_subtotal = ($scope.tr_payments.deposit_total - ($scope.tr_payments.deposit_total * $scope.tr_payments.deposit_discount));
        var index = 0;

        var total_price_tuition = 0;
        var grand_total_tuition = 0;
        var total_disc_tuition = 0;
        $scope.data_tuition = [];
        angular.forEach($scope.cart_tuition, function(val, key) {
            total_price_tuition += parseInt(val.price);
            grand_total_tuition += parseInt(val.subtotal);
            total_disc_tuition += (parseInt(val.subtotal) * parseInt(val.discount));
            // $scope.data_tuition[index] = val;
            // index += 1;
        });

        var total_price_item = 0;
        var grand_total_item = 0;
        var total_disc_item = 0;
        $scope.data_tuition = [];
        angular.forEach($scope.cart_item, function(val, key) {
            total_price_item += (parseInt(val.price) * parseInt(val.qty));
            grand_total_item += parseInt(val.subtotal);
            total_disc_item += (parseInt(val.subtotal) * parseInt(val.discount));
            // $scope.data_item[index] = val;
            // index += 1;
        });

        $scope.tr_payments.total_price = (total_price_tuition + total_price_item) + $scope.tr_payments.deposit_total;
        $scope.tr_payments.grand_total = ((grand_total_tuition + grand_total_item) + $scope.tr_payments.deposit_subtotal) - $scope.tr_payments.voucher.price;
    }

    // Kalkulasi Quantity
    $scope.calcQty = function(elm) {
        if (elm.item.qty == null | elm.item.qty == 0) {
            elm.item.qty = 1;
            elm.item.subtotal = (parseInt(elm.item.price) - parseInt(elm.item.price * elm.item.discount)) * elm.item.qty;
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        } else {
            elm.item.subtotal = (parseInt(elm.item.price) - parseInt(elm.item.price * elm.item.discount)) * elm.item.qty;
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        }

        $scope.tr_payments.cash = 0;
        $scope.tr_payments.debit = 0;
        $scope.tr_payments.transfer = 0;
        $scope.tr_payments.total_method = 0;
        $scope.tr_payments.balance = 0;
        $scope.tr_payments.voucher = $scope.vouchers[0];
    };

    // Kalkulasi Discount
    $scope.calcDiscAll = function(elm) {
        var index = 0;

        var total_disc_tuition = 0;
        $scope.disc_tuition = [];
        angular.forEach($scope.cart_tuition, function(val, key) {
            total_disc_tuition += (parseInt(val.price) * val.discount);
        });


        var total_disc_item = 0;
        $scope.disc_item = [];
        angular.forEach($scope.cart_item, function(val, key) {
            total_disc_item += ((parseInt(val.price) * val.discount) * parseInt(val.qty));
        });

        $scope.tr_payments.discount = (total_disc_tuition + total_disc_item) + ($scope.tr_payments.deposit_total * $scope.tr_payments.deposit_discount);
    };

    // Kalkulasi Disc Tuition
    $scope.calcDiscTuition = function(elm) {
        if (elm.tuition.discount == null | elm.tuition.discount == 0 | isNaN(elm.tuition.discount)) {
            elm.tuition.discount = 0;
            elm.tuition.subtotal = (parseInt(elm.tuition.price) - parseInt(elm.tuition.price * elm.tuition.discount));
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        } else if (elm.tuition.discount > 1) {
            elm.tuition.discount = 0;
            elm.tuition.subtotal = (parseInt(elm.tuition.price) - parseInt(elm.tuition.price * elm.tuition.discount));
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        } else if (elm.tuition.discount > 0) {
            elm.tuition.subtotal = (parseInt(elm.tuition.price) - parseInt(elm.tuition.price * elm.tuition.discount));
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        }

        $scope.tr_payments.cash = 0;
        $scope.tr_payments.debit = 0;
        $scope.tr_payments.transfer = 0;
        $scope.tr_payments.total_method = 0;
        $scope.tr_payments.balance = 0;
        $scope.tr_payments.voucher = $scope.vouchers[0];
    };

    // Kalkulasi Disc Item
    $scope.calcDiscItem = function(elm) {
        if (elm.item.discount == null | elm.item.discount == 0 | isNaN(elm.item.discount)) {
            elm.item.discount = 0;
            elm.item.subtotal = (parseInt(elm.item.price) - parseInt(elm.item.price * elm.item.discount)) * elm.item.qty;
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        } else if (elm.item.discount > 1) {
            elm.item.discount = 0;
            elm.item.subtotal = (parseInt(elm.item.price) - parseInt(elm.item.price * elm.item.discount)) * elm.item.qty;
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        } else if (elm.item.discount > 0) {
            elm.item.subtotal = (parseInt(elm.item.price) - parseInt(elm.item.price * elm.item.discount)) * elm.item.qty;
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        }

        $scope.tr_payments.cash = 0;
        $scope.tr_payments.debit = 0;
        $scope.tr_payments.transfer = 0;
        $scope.tr_payments.total_method = 0;
        $scope.tr_payments.balance = 0;
        $scope.tr_payments.voucher = $scope.vouchers[0];
    };

    // Kalkulasi Deposit Books
    $scope.calcDepositTotal = function(elm) {
        if ($scope.tr_payments.deposit_total == null | $scope.tr_payments.deposit_total == 0) {
            $scope.tr_payments.deposit_total = 0;
            $scope.tr_payments.deposit_subtotal = ($scope.tr_payments.deposit_total - ($scope.tr_payments.deposit_total * $scope.tr_payments.deposit_discount));
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        } else {
            $scope.tr_payments.deposit_subtotal = ($scope.tr_payments.deposit_total - ($scope.tr_payments.deposit_total * $scope.tr_payments.deposit_discount));
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        }

        $scope.tr_payments.cash = 0;
        $scope.tr_payments.debit = 0;
        $scope.tr_payments.transfer = 0;
        $scope.tr_payments.total_method = 0;
        $scope.tr_payments.balance = 0;
        $scope.tr_payments.voucher = $scope.vouchers[0];
    }

    $scope.calcDepositDisc = function(elm) {
        if ($scope.tr_payments.deposit_discount == null | $scope.tr_payments.deposit_discount == 0 | isNaN($scope.tr_payments.deposit_discount)) {
            $scope.tr_payments.deposit_discount = 0;
            $scope.tr_payments.deposit_subtotal = ($scope.tr_payments.deposit_total - ($scope.tr_payments.deposit_total * $scope.tr_payments.deposit_discount));
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        } else if ($scope.tr_payments.deposit_discount > 0.9) {
            $scope.tr_payments.deposit_total = 0;
            $scope.tr_payments.deposit_subtotal = ($scope.tr_payments.deposit_total - ($scope.tr_payments.deposit_total * $scope.tr_payments.deposit_discount));
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        } else {
            $scope.tr_payments.deposit_subtotal = ($scope.tr_payments.deposit_total - ($scope.tr_payments.deposit_total * $scope.tr_payments.deposit_discount));
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
        }

        $scope.tr_payments.cash = 0;
        $scope.tr_payments.debit = 0;
        $scope.tr_payments.transfer = 0;
        $scope.tr_payments.total_method = 0;
        $scope.tr_payments.balance = 0;
        $scope.tr_payments.voucher = $scope.vouchers[0];
    }

    // Kalkulasi Total Method
    $scope.calcTotalMethod = function(elm) {
        if ($scope.tr_payments.cash == null | $scope.tr_payments.cash == 0) {
            $scope.tr_payments.cash = 0;
            $scope.tr_payments.total_method = ($scope.tr_payments.cash + $scope.tr_payments.debit + $scope.tr_payments.transfer);
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
            $scope.calcBalanceTotal();
        } else if ($scope.tr_payments.debit == null | $scope.tr_payments.debit == 0) {
            $scope.tr_payments.debit = 0;
            $scope.tr_payments.total_method = ($scope.tr_payments.cash + $scope.tr_payments.debit + $scope.tr_payments.transfer);
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
            $scope.calcBalanceTotal();
        } else if ($scope.tr_payments.transfer == null | $scope.tr_payments.transfer == 0) {
            $scope.tr_payments.transfer = 0;
            $scope.tr_payments.total_method = ($scope.tr_payments.cash + $scope.tr_payments.debit + $scope.tr_payments.transfer);
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
            $scope.calcBalanceTotal();
        } else {
            $scope.tr_payments.total_method = ($scope.tr_payments.cash + $scope.tr_payments.debit + $scope.tr_payments.transfer);
            $scope.calcTotalPrice();
            $scope.calcDiscAll();
            $scope.calcBalanceTotal();
        }
    }

    //Kalkulasi Balance
    $scope.calcBalanceTotal = function(elm) {
        if ($scope.tr_payments.total_method < $scope.tr_payments.grand_total) {
            $scope.tr_payments.balance = 0;
        } else {
            $scope.tr_payments.balance = $scope.tr_payments.total_method - $scope.tr_payments.grand_total;
        }
    }

    //##############################//
    //        SELECT VOUCHER        //
    //##############################//
    $scope.selectVoucher = function(elm, voucher) {
        if (voucher.id == 0) {
            $scope.calcTotalPrice();
            $scope.calcBalanceTotal();
        } else {
            $scope.calcTotalPrice();
            $scope.calcBalanceTotal();
        }
    }

    //##############################//
    //     MENAMBAH CART TUITION    //
    //##############################//
    $scope.cart_tuition = [];
    $scope.tuitionAdd = function(input) {
        console.log(input);
        trPaymentsFactory.getDataTuition({
            tuition_id: input.id
        }).then(function() {
            $scope.get_tuition = trPaymentsFactory.resDataTuition;
			console.log("data", $scope.get_tuition);
            $scope.cart_tuition.push({
                "tuition_id": $scope.get_tuition.id
                , "name": $scope.get_tuition.name
                , "price": $scope.get_tuition.price
                , "discount": 0
                , "qty": 1
                , "subtotal": $scope.get_tuition.price * 1
            });
            $scope.calcTotalPrice();
        });
    }

    //##############################//
    //      MENAMBAH CART ITEM      //
    //##############################//
    $scope.cart_item = [];
    $scope.itemAdd = function(input) {
        if (input.qty < 1) {
            toastr.error('Stock is empty', 'Failed!');
            return;
        } else {
            trPaymentsFactory.getDataItem({
                item_id: input.id
            }).then(function() {
                $scope.get_item = trPaymentsFactory.resDataItem;
                $scope.cart_item.push({
                    "item_id": $scope.get_item.id
                    , "name": $scope.get_item.name
                    , "price": $scope.get_item.price_sell
                    , "discount": 0
                    , "qty": 1
                    , "subtotal": $scope.get_item.price_sell * 1
                });
                $scope.calcTotalPrice();
            });
        }
    }

    //##############################//
    //     MENGHAPUS DATA CART      //
    //##############################//
    $scope.item_id = '';
    $scope.getItemId = function (elm, input) {
        $scope.item_id = input.row_id;
        angular.element('.vs-box-reveal').addClass('vs-show');
    }

    $scope.cartRemoveTuition = function(elm, input) {
        $scope.cart_tuition.splice(elm.$index, 1);
        $scope.calcTotalPrice();
        $scope.calcBalanceTotal();
    }

    $scope.cartRemoveItem = function(elm, input) {
        $scope.cart_item.splice(elm.$index, 1);
        console.log(elm);
        if (elm.item.starter_kids == 'A') {
            $scope.add_starter_kids = false;
        }
        $scope.calcTotalPrice();
        $scope.calcBalanceTotal();
    }

    //##############################//
    //       ADD STARTER KIDS       //
    //##############################//
    $scope.add_starter_kids = false;
    $scope.addStarterKids = function(elm, flag) {
        if (flag) {
            $scope.add_starter_kids = false;
            $scope.cart_item.splice(elm.cart_item.starter_kids);
            $scope.calcTotalPrice();
        } else {
            $scope.add_starter_kids = true;
            itemFactory.getStarterKids({
                starter_kids: 'A'
            }).then(function() {
                $scope.starter_kids = itemFactory.allDataStarterKids;
                var stock_empty = 0;
                angular.forEach($scope.starter_kids, function(value, key){
                    if (value.qty == 0) {
                        stock_empty += 1;
                        return;
                    }
                });

                if (stock_empty != 0) {
                    $scope.add_starter_kids = false;
                    toastr.error('Stock is empty', 'Failed!');
                    $scope.calcTotalPrice();
                    return;
                } else {
                    angular.forEach($scope.starter_kids, function(value, key){
                        $scope.cart_item.push({
                            "item_id": value.id
                            , "name": value.name
                            , "price": value.price_starter_kids
                            , "discount": 0
                            , "qty": 1
                            , "subtotal": value.price_starter_kids * 1
                            , "starter_kids": value.starter_kids
                        });
                    });
                    $scope.calcTotalPrice();
                }

            });
        }

        $scope.tr_payments.cash = 0;
        $scope.tr_payments.debit = 0;
        $scope.tr_payments.transfer = 0;
        $scope.tr_payments.total_method = 0;
        $scope.tr_payments.balance = 0;
        $scope.tr_payments.voucher = $scope.vouchers[0];
    }

    // Fungsi Simpan data tanpa cetak
    $scope.createData = function() {
        if ($scope.tr_payments.invoice == '') {
            toastr.error('Invoice number is required', 'Failed!');
            return;
        } else if ($scope.student.name == '') {
            toastr.error('Student is required', 'Failed!');
            return;
        } else {
            $scope.loading = true;
            angular.element('#btn-save').attr('disabled', true);
            trPaymentsFactory.insertDataTrPayments({
                student: $scope.student,
                tr_payments: $scope.tr_payments,
                cart_tuition: $scope.cart_tuition,
                cart_item: $scope.cart_item,
            }).then(function() {
                var validation = trPaymentsFactory.resultInsert;
                if (validation == 'invalid') {
                    $scope.loading = false;
                    toastr.error('Invoice number has been used', 'Failed!');
                    angular.element('#btn-save').attr('disabled', false);
                    return;
                } else {
                    $state.reload();
                    angular.element('#btn-save').attr('disabled', false);
                    $scope.tr_payments = {
                        total_price: 0,
                        discount: 0,
                        grand_total: 0,
                        payment: 0,
                        cash: 0,
                        debit: 0,
                        transfer: 0,
                        total_method: 0,
                        deposit_total: 0,
                        deposit_discount: 0,
                        deposit_subtotal: 0,
                        balance: 0
                    };
                    $scope.loading = false;
                    toastr.success('Data has been saved', 'Success!');
                }
            });
        }
    };

    // Fungsi Simpan data dengan cetak
    $scope.createPrintData = function() {
        $scope.loading = true;
        $scope.process = true;
        angular.element('#btn-save-print').attr('disabled', true);
        angular.element('#btn-save').attr('disabled', true);
        trPaymentsFactory.insertDataTrPayments({
            transaction_sales: $scope.tr_sales,
            cart: $scope.cart_sales,
            code: $scope.invoice,
        }).then(function() {
            $window.print();
            angular.element('#btn-save-print').attr('disabled', false);
            angular.element('#btn-save').attr('disabled', false);
            $scope.generateInvoice();
            $scope.barcode = "";
            $scope.tr_sales = {
                total_price: 0,
                discount: 0,
                discprice: 0,
                grand_total: 0,
                payment: 0,
                balance: 0
            };
            angular.element('#search-tablet').focus();
            $scope.notification();
            $scope.loading = false;
            $scope.process = false;
            $state.reload();
        });
    };

    // Fungsi Cetak data terakhir
    $scope.show = false;
    $scope.printLastTrSales = function() {
        $scope.show = true;
        $scope.loading = true;
        trPaymentsFactory.printLastTrSales().then(function() {
            $scope.tr_sales_last = {
                invoice: trPaymentsFactory.resLastTrSales[0].code,
                date: $filter('date')(trPaymentsFactory.resLastTrSales[0].date, 'dd-MM-yy'),
                total_price: trPaymentsFactory.resLastTrSales[0].total_price,
                discount_item: trPaymentsFactory.resLastTrSales[0].discount_item,
                discount: trPaymentsFactory.resLastTrSales[0].discount,
                discprice: trPaymentsFactory.resLastTrSales[0].discount_price,
                grand_total: trPaymentsFactory.resLastTrSales[0].grand_total,
                payment: trPaymentsFactory.resLastTrSales[0].payment,
                balance: trPaymentsFactory.resLastTrSales[0].balance,
            };
            $scope.data_cart_last = trPaymentsFactory.resLastTrSales;
            $timeout(function() {
                $window.print();
                $scope.show = false;
                $scope.loading = false;
            }, 3000);
        });
    };

    //##############################//
    //       FUNGSI EDIT DATA       //
    //##############################//
    if ($state.current.name == "trPayments-edit") {
        $scope.trPayments = {};
        trPaymentsFactory.getDataEachTrPayments($stateParams.id)
            .then(function() {
                $scope.trPayments = trPaymentsFactory.eachDataTrPayments;
            });

        $scope.updateData = function() {
            angular.element('#btn-save').attr('disabled', true);
            trPaymentsFactory.updateDataTrPayments({
                id: $stateParams.id,
                trPayments: $scope.trPayments
            }).then(function() {
                $state.go("trPayments-list");
                angular.element('#btn-save').attr('disabled', false);
            });
        }
    }
})
