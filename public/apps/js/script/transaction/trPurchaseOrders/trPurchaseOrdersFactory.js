var app = angular.module('factoryTrPurchaseOrders', []);
app.factory('trPurchaseOrdersFactory', function($http, $filter, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataTrPurchaseOrders = [];
    init.totalItems = [];
    init.eachDataTrPurchaseOrders = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataTrPurchaseOrders = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrders/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataTrPurchaseOrders = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrders/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.insertDataTrPurchaseOrders = function(input) {
        return $http({
            method: 'POST',
            url: 'trPurchaseOrders/insert',
            data: {
                invoice: input.tr_purchases.invoice,
                date: $filter('date')(input.tr_purchases.date, 'yy-MM-dd'),
                total: input.tr_purchases.total_price,
                discount: input.tr_purchases.discount,
                grand_total: input.tr_purchases.grand_total,
                note: input.tr_purchases.note,
                cart_item: input.cart_item,
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

    init.getDataEachTrPurchaseOrders = function(input) {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrders/edit/' + input,
        }).then(function(response) {
            init.dataTrPurchaseOrders = response.data.tr_purchases;
            init.dataSupplier = response.data.supplier;
            init.dataTrPurchaseOrdersDetail = response.data.tr_purchases_detail;
            console.log("Resp", response);
        }, function(response) {});
    }

    init.updateDataTrPurchaseOrders = function(input) {
        console.log("Data Input", input);
        return $http({
            method: 'POST',
            url: 'trPurchaseOrders/update/' + input.id,
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

    init.getAllDataTrPurchaseOrders = function() {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrders/all',
        }).then(function(response) {
            init.allDataTrPurchaseOrders = response.data;
        }, function(response) {});
    }

    init.getDataCart = function() {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrders/getCart'
        }).then(function(response) {
            init.resDataCart = response.data;
        }, function(response) {});
    }

    init.deleteDataReportTransPurchases = function(input) {
        return $http({
            method: 'POST',
            url: 'trPurchaseOrders/delete/' + input.id
        }).then(function(response) {
			toastr.success('Data has been deleted', 'Success!');
        }, function(response) {});
    }

    // Search Item
    init.getDataItem = function(input) {
        return $http({
            method: 'GET',
            url: 'trPurchaseOrders/searchItemManual/' + input.item_id
        }).then(function(response) {
            init.resDataItem = response.data;
        }, function(response) {});
    }

    return init;
})
