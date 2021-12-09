var app = angular.module('trChangeStampsCtrl', ['factoryTrChangeStamps']);

app.controller('trChangeStampsController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $filter, $parse, $state, $compile, toastr, hotkeys, trChangeStampsFactory, studentFactory, tuitionFactory, stampFactory, itemFactory, voucherFactory) {

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
        , deposit: 0
    };

    $scope.tr_changestamps = {
        subtotal: 0
        , deposit_before: 0
        , deposit_after: 0
        , date: $filter('date')(new Date(), 'yyyy-MM-dd')
        , note: ''
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
            $scope.tr_changestamps.deposit_before = studentFactory.dataStudentDetail.data_student.deposit;
            $scope.loadingSupp = false;
            $scope.calcDepositBalance();
            return $scope.student;
        });
    }

    //##############################//
    //      PENCARIAN ITEM      //
    //##############################//
    $scope.searchStamp = function(typo, response) {
        stampFactory.searchStamp({
            typo: typo.term
        }).then(function() {
            $scope.data_item = stampFactory.resSearchStamp;
            if ($scope.data_item.length > 0) {
                response($scope.data_item);
            } else {
                response([{id: "0", name: "Data was not found"}]);
            }
        });
    };

    //##############################//
    //       GENERATE INVOICE       //
    //##############################//
    $scope.generateInvoice = function () {
        $scope.invoice = "SL" + $filter('date')(new Date(), 'yy') + $filter('date')(new Date(), 'MM') + $filter('date')(new Date(), 'dd') + $filter('date')(new Date(), 'hh') + $filter('date')(new Date(), 'mm') + $filter('date')(new Date(), 'ss');
    }

    $scope.generateInvoice();

    //##############################//
    //    PERHITUNGAN PENJUALAN     //
    //##############################//
    $scope.calcDepositBalance = function(elm) {
        var index = 0;

        var total_price_item = 0;
        var grand_total_item = 0;
        var total_disc_item = 0;
        angular.forEach($scope.cart_item, function(val, key) {
            total_price_item += parseInt(val.price);
        });

        $scope.tr_changestamps.subtotal = total_price_item;
        $scope.tr_changestamps.deposit_after = $scope.student.deposit - total_price_item;
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
            trChangeStampsFactory.getDataStamp({
                item_id: input.id
            }).then(function() {
                $scope.get_item = trChangeStampsFactory.resDataStamp;
                $scope.cart_item.push({
                    "stamp_id": $scope.get_item.id
                    , "name": $scope.get_item.name
                    , "price": $scope.get_item.price
                    , "stamp": $scope.get_item.stamp
                    , "discount": 0
                    , "qty": 1
                    , "subtotal": $scope.get_item.price * 1
                });
                $scope.calcDepositBalance();
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

    $scope.cartRemoveItem = function(elm, input) {
        $scope.cart_item.splice(elm.$index, 1);
        $scope.calcDepositBalance();
    }

    //##############################//
    // PENCARIAN MANUAL DATA BARANG //
    //##############################//
    // Fungsi pencarian data barang manual
    $scope.searchItem = function(typo, response) {
        itemFactory.searchItemManual({
            typo: typo.term
        }).then(function() {
            $scope.data_item = itemFactory.resSearchItem;
            if ($scope.data_item.length > 0) {
                // angular.element('#search-tablet').val('');
                // $scope.barcodeAdd = '';
                response($scope.data_item);
            }
        });
    };

    // Fungsi Simpan data tanpa cetak
    $scope.createData = function() {
        if ($scope.student.name == '') {
            toastr.error('Student is required', 'Failed!');
            return;
        } else if ($scope.tr_changestamps.subtotal < 1) {
            toastr.error('Stamp cart is empty', 'Failed!');
            return;
        } else {
            $scope.loading = true;
            angular.element('#btn-save').attr('disabled', true);
            trChangeStampsFactory.insertDataTrChangeStamps({
                student: $scope.student,
                tr_changestamps: $scope.tr_changestamps,
                cart_item: $scope.cart_item,
            }).then(function() {
                $state.reload();
                angular.element('#btn-save').attr('disabled', false);
                $scope.tr_changestamps = {
                    subtotal: 0
                    , deposit_before: 0
                    , deposit_after: 0
                    , date: $filter('date')(new Date(), 'yyyy-MM-dd')
                    , note: ''
                };
                $scope.loading = false;
            });
        }
    };

    // Fungsi Simpan data dengan cetak
    $scope.createPrintData = function() {
        $scope.loading = true;
        $scope.process = true;
        angular.element('#btn-save-print').attr('disabled', true);
        angular.element('#btn-save').attr('disabled', true);
        trChangeStampsFactory.insertDataTrChangeStamps({
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
        trChangeStampsFactory.printLastTrSales().then(function() {
            $scope.tr_sales_last = {
                invoice: trChangeStampsFactory.resLastTrSales[0].code,
                date: $filter('date')(trChangeStampsFactory.resLastTrSales[0].date, 'dd-MM-yy'),
                total_price: trChangeStampsFactory.resLastTrSales[0].total_price,
                discount_item: trChangeStampsFactory.resLastTrSales[0].discount_item,
                discount: trChangeStampsFactory.resLastTrSales[0].discount,
                discprice: trChangeStampsFactory.resLastTrSales[0].discount_price,
                grand_total: trChangeStampsFactory.resLastTrSales[0].grand_total,
                payment: trChangeStampsFactory.resLastTrSales[0].payment,
                balance: trChangeStampsFactory.resLastTrSales[0].balance,
            };
            $scope.data_cart_last = trChangeStampsFactory.resLastTrSales;
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
    if ($state.current.name == "trChangeStamps-edit") {
        $scope.trChangeStamps = {};
        trChangeStampsFactory.getDataEachTrChangeStamps($stateParams.id)
            .then(function() {
                $scope.trChangeStamps = trChangeStampsFactory.eachDataTrChangeStamps;
            });

        $scope.updateData = function() {
            angular.element('#btn-save').attr('disabled', true);
            trChangeStampsFactory.updateDataTrChangeStamps({
                id: $stateParams.id,
                trChangeStamps: $scope.trChangeStamps
            }).then(function() {
                $state.go("trChangeStamps-list");
                angular.element('#btn-save').attr('disabled', false);
            });
        }
    }
})
