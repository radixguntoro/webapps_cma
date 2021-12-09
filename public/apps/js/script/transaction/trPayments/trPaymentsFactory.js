var app = angular.module('factoryTrPayments', []);
app.factory('trPaymentsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataTrPayments = [];
    init.totalItems = [];
    init.eachDataTrPayments = [];
    init.resultInsert = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataTrPayments = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'trPayments/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataTrPayments = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'trPayments/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataTrPayments = function(pageNumber, dateStart, dateEnd) {
        return $http({
            method: 'GET',
            url: 'trPayments/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.insertDataTrPayments = function(input) {
        return $http({
            method: 'POST',
            url: 'trPayments/insert',
            data: {
                date: input.tr_payments.date
                , invoice: input.tr_payments.invoice
                , cash: input.tr_payments.cash
                , debit: input.tr_payments.debit
                , transfer: input.tr_payments.transfer
                , method_total: input.tr_payments.total_method
                , subtotal: input.tr_payments.total_price
                , discount: input.tr_payments.discount
                , discount_voucher: input.tr_payments.voucher.price
                , voucher_id: input.tr_payments.voucher.id
                , grand_total: input.tr_payments.grand_total
                , balance: input.tr_payments.balance
                , note: input.tr_payments.note
                , student_id: input.student.id
                , student_deposit: input.student.deposit
                , deposit_total: input.tr_payments.deposit_total
                , deposit_discount: input.tr_payments.deposit_discount
                , deposit_subtotal: input.tr_payments.deposit_subtotal
                , cart_tuition: input.cart_tuition
                , cart_item: input.cart_item
            },
        }).then(function(response) {
            if (response.data == 'invalid') {
                init.resultInsert = "invalid";
            } else {
                init.resultInsert = "valid";
            }
        }, function(response) {
            toastr.error('Data failed to save', 'Failed!');
        });
    }

    init.getDataEachTrPayments = function(input) {
        return $http({
            method: 'GET',
            url: 'trPayments/edit/' + input,
        }).then(function(response) {
            init.eachDataTrPayments = response.data;
        }, function(response) {});
    }

    init.updateDataTrPayments = function(input) {
        return $http({
            method: 'POST',
            url: 'trPayments/update/' + input.id,
            data: {
                name: input.trPayments.name,
                parent_id: input.trPayments_parent,
                status: input.trPayments_status
            }
        }).then(function(response) {
            toastr.success('Data has been changed', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    init.getAllDataTrPayments = function() {
        return $http({
            method: 'GET',
            url: 'trPayments/all',
        }).then(function(response) {
            init.allDataTrPayments = response.data;
        }, function(response) {});
    }

    init.getDataCart = function(input) {
        return $http({
            method: 'GET',
            url: 'trPayments/getCart/' + input.user_id
        }).then(function(response) {
            init.resDataCart = response.data;
        }, function(response) {});
    }

    // Search Tuition
    init.getDataTuition = function(input) {
        return $http({
            method: 'GET',
            url: 'trPayments/searchTuitionManual/' + input.tuition_id
        }).then(function(response) {
            init.resDataTuition = response.data;
        }, function(response) {});
    }

    // Search Item
    init.getDataItem = function(input) {
        return $http({
            method: 'GET',
            url: 'trPayments/searchItemManual/' + input.item_id
        }).then(function(response) {
            init.resDataItem = response.data;
        }, function(response) {});
    }

    init.printLastTrSales = function() {
        return $http({
            method: 'GET',
            url: 'trPayments/printLastTrSales'
        }).then(function(response) {
            console.log(response.data);
            init.resLastTrSales = response.data;
        }, function(response) {});
    }

    return init;
})
