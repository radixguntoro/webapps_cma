var app = angular.module('factoryTrPurchaseOrderStamps', []);
app.factory('trPurchaseOrderStampsFactory', function($http, $filter, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataTrPurchaseOrderStamps = [];
    init.totalItems = [];
    init.eachDataTrPurchaseOrderStamps = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataTrPurchaseOrderStamps = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrderStamps/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataTrPurchaseOrderStamps = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrderStamps/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.insertDataTrPurchaseOrderStamps = function(input) {
        console.log("Inputan", input);
        return $http({
            method: 'POST',
            url: 'trPurchaseOrderStamps/insert',
            data: {
                invoice: input.tr_purchases.invoice,
                date: $filter('date')(input.tr_purchases.date, 'yy-MM-dd'),
                total: input.tr_purchases.total_price,
                discount: input.tr_purchases.discount,
                grand_total: input.tr_purchases.grand_total,
                note: input.tr_purchases.note,
                cart_stamp: input.cart_stamp,
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

    init.getDataEachTrPurchaseOrderStamps = function(input) {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrderStamps/edit/' + input,
        }).then(function(response) {
            init.dataTrPurchaseOrderStamps = response.data.tr_purchases;
            init.dataSupplier = response.data.supplier;
            init.dataTrPurchaseOrderStampsDetail = response.data.tr_purchases_detail;
            console.log("Resp", response);
        }, function(response) {});
    }

    init.updateDataTrPurchaseOrderStamps = function(input) {
        console.log("Data Input", input);
        return $http({
            method: 'POST',
            url: 'trPurchaseOrderStamps/update/' + input.id,
            data: {
                cart: input.cart,
                tr_purchases_cart: input.tr_purchases_cart,
                total_price: input.tr_purchases.total_price,
                disc_total: input.tr_purchases.disc_total,
                ppn: input.tr_purchases.ppn,
                grand_total: input.tr_purchases.grand_total,
                supplier_id: input.supplier.id
            }
        }).then(function(response) {
            toastr.success('Data has been changed', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    init.getAllDataTrPurchaseOrderStamps = function() {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrderStamps/all',
        }).then(function(response) {
            init.allDataTrPurchaseOrderStamps = response.data;
        }, function(response) {});
    }

    init.getDataCart = function() {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrderStamps/getCart'
        }).then(function(response) {
            init.resDataCart = response.data;
        }, function(response) {});
    }

    init.deleteDataReportTransPurchases = function(input) {
        return $http({
            method: 'POST',
            url: 'trPurchaseOrderStamps/delete/' + input.id
        }).then(function(response) {
			toastr.success('Data has been deleted', 'Success!');
        }, function(response) {});
    }

    // Search Stamp
    init.getDataStamp = function(input) {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrderStamps/searchStampManual/' + input.stamp_id
        }).then(function(response) {
            init.resDataStamp = response.data;
        }, function(response) {});
    }

    return init;
})
