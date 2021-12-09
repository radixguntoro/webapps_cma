var app = angular.module('trChangeBooksCtrl', ['factoryTrChangeBooks', 'factoryReportTrChangeBooks']);

app.controller('trChangeBooksController', function ($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $filter, $parse, $state, $compile, toastr, hotkeys, trChangeBooksFactory, studentFactory, tuitionFactory, itemFactory, reportTrChangeBooksFactory) {

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

    $scope.tr_changebooks = {
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
            $scope.tr_changebooks.deposit_before = studentFactory.dataStudentDetail.data_student.deposit;
            $scope.loadingSupp = false;
            $scope.calcDepositBalance();
            return $scope.student;
        });
    }

    $scope.validStudent = function (elm) {
        $scope.report.student_id = '';
    }

    //##############################//
    //      PENCARIAN ITEM      //
    //##############################//
    $scope.searchItem = function(typo, response) {
        itemFactory.searchBookOnly({
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

        $scope.tr_changebooks.subtotal = total_price_item;
        $scope.tr_changebooks.deposit_after = $scope.student.deposit - total_price_item;
        console.log("Sisa Deposit", $scope.tr_changebooks.deposit_after );
    }

    //##############################//
    //      MENAMBAH CART ITEM      //
    //##############################//
    $scope.cart_item = [];
    $scope.itemAdd = function(input) {
        if (input.qty < 1) {
            toastr.error('Stock is empty', 'Failed!');
            return;
        } else if ($scope.student.name == '') {
            toastr.error('Student is required', 'Failed!');
            return;
        } else {
            trChangeBooksFactory.getDataItem({
                item_id: input.id
            }).then(function() {
                $scope.get_item = trChangeBooksFactory.resDataItem;
                $scope.cart_item.push({
                    "item_id": $scope.get_item.id
                    , "name": $scope.get_item.name
                    , "price": $scope.get_item.price_sell
                    , "deposit_before": $scope.get_item.deposit_before > 0 ? parseInt($scope.tr_changebooks.deposit_after) + parseInt($scope.get_item.price_sell) : $scope.tr_changebooks.deposit_after
                    , "deposit_after": $scope.tr_changebooks.deposit_after - $scope.get_item.price_sell
                    , "discount": 0
                    , "qty": 1
                    , "subtotal": $scope.get_item.price_sell * 1
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

    // Fungsi Simpan data tanpa cetak
    $scope.createData = function() {
        if ($scope.student.name == '') {
            toastr.error('Student is required', 'Failed!');
            return;
        } else if ($scope.cart_item.length < 1) {
            toastr.error('Book cart is empty', 'Failed!');
            return;
        } else {
            $scope.loading = true;
            angular.element('#btn-save').attr('disabled', true);
            trChangeBooksFactory.insertDataTrChangeBooks({
                student: $scope.student,
                tr_changebooks: $scope.tr_changebooks,
                cart_item: $scope.cart_item,
            }).then(function() {
                $state.reload();
                angular.element('#btn-save').attr('disabled', false);
                $scope.tr_changebooks = {
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
        trChangeBooksFactory.insertDataTrChangeBooks({
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
        trChangeBooksFactory.printLastTrSales().then(function() {
            $scope.tr_sales_last = {
                invoice: trChangeBooksFactory.resLastTrSales[0].code,
                date: $filter('date')(trChangeBooksFactory.resLastTrSales[0].date, 'dd-MM-yy'),
                total_price: trChangeBooksFactory.resLastTrSales[0].total_price,
                discount_item: trChangeBooksFactory.resLastTrSales[0].discount_item,
                discount: trChangeBooksFactory.resLastTrSales[0].discount,
                discprice: trChangeBooksFactory.resLastTrSales[0].discount_price,
                grand_total: trChangeBooksFactory.resLastTrSales[0].grand_total,
                payment: trChangeBooksFactory.resLastTrSales[0].payment,
                balance: trChangeBooksFactory.resLastTrSales[0].balance,
            };
            $scope.data_cart_last = trChangeBooksFactory.resLastTrSales;
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
    if ($state.current.name == "trChangeBooks-edit") {
        $scope.trChangeBooks = {};
        trChangeBooksFactory.getDataEachTrChangeBooks($stateParams.id)
            .then(function() {
                $scope.trChangeBooks = trChangeBooksFactory.eachDataTrChangeBooks;
            });

        $scope.updateData = function() {
            angular.element('#btn-save').attr('disabled', true);
            trChangeBooksFactory.updateDataTrChangeBooks({
                id: $stateParams.id,
                trChangeBooks: $scope.trChangeBooks
            }).then(function() {
                $state.go("trChangeBooks-list");
                angular.element('#btn-save').attr('disabled', false);
            });
        }
    }

    $scope.dateReportOptions = {
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    };

    $scope.report = {};
    $scope.report.datestart = $filter('date')(new Date(), 'yyyy-MM-dd');
    $scope.report.dateend = $filter('date')(new Date(), 'yyyy-MM-dd');

    $scope.listData = function () {
        $state.go("tr-changebook-list");
    }

    $scope.filterData = function () {
        if ($scope.report.datestart == null || $scope.report.dateend == null) {
            toastr.error('Pilihan Tanggal masih kosong', 'Pencarian Gagal!');
            return true;
        } else {
            $scope.loading = true;
            var date_start = $scope.report.datestart != null ? $filter('date')($scope.report.datestart, 'yyyy-MM-dd') : '';
            var date_end = $scope.report.dateend != null ? $filter('date')($scope.report.dateend, 'yyyy-MM-dd') : '';
            var student_id = $scope.student.id > 0 ? $scope.student.id : '';
            console.log(student_id);
            
            trChangeBooksFactory.filterDataTrChangeBooks(date_start, date_end, student_id)
                .then(function () {
                    $scope.data = trChangeBooksFactory.resultData;
                    $scope.loading = false;
                    console.log($scope.data);
                });
        }
    }

    $scope.deleteData = function (elm, tr_change_book) {
        $scope.loadingDetail = true;
        trChangeBooksFactory.deleteTrChangeBooks({
            tr_change_book_id: tr_change_book.id
        }).then(function () {
            $scope.filterData();
            $scope.loadingDetail = false;
            toastr.success('Data has been deleted', 'Success!');
        });
    }
})
