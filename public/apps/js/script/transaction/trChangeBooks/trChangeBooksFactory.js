var app = angular.module('factoryTrChangeBooks', []);
app.factory('trChangeBooksFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataTrChangeBooks = [];
    init.totalItems = [];
    init.eachDataTrChangeBooks = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataTrChangeBooks = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'trChangeBooks/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataTrChangeBooks = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'trChangeBooks/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataTrChangeBooks = function (date_start, date_end, student_id) {
        return $http({
            method: 'GET',
            url: 'trChangeBooks/filter?student=' + student_id + '&datestart=' + date_start + '&dateend=' + date_end
        }).then(function (response) {
            init.resultData = response.data;
            console.log(response);
        }, function (response) {});
    };

    init.insertDataTrChangeBooks = function(input) {
        console.log(input);
        return $http({
            method: 'POST',
            url: 'trChangeBooks/insert',
            data: {
                date: input.tr_changebooks.date
                , subtotal: input.tr_changebooks.subtotal
                , deposit_before: input.tr_changebooks.deposit_before
                , deposit_after: input.tr_changebooks.deposit_after
                , note: input.tr_changebooks.note
                , student_id: input.student.id
                , cart_item: input.cart_item
            },
        }).then(function(response) {
           toastr.success('Data has been saved', 'Success!');
        }, function(response) {
            toastr.error('Data failed to save', 'Failed!');
        });
    }

    init.getDataEachTrChangeBooks = function(input) {
        return $http({
            method: 'GET',
            url: 'trChangeBooks/edit/' + input,
        }).then(function(response) {
            init.eachDataTrChangeBooks = response.data;
        }, function(response) {});
    }

    init.updateDataTrChangeBooks = function(input) {
        return $http({
            method: 'POST',
            url: 'trChangeBooks/update/' + input.id,
            data: {
                name: input.trChangeBooks.name,
                parent_id: input.trChangeBooks_parent,
                status: input.trChangeBooks_status
            }
        }).then(function(response) {
            toastr.success('Data has been saved', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    init.getAllDataTrChangeBooks = function() {
        return $http({
            method: 'GET',
            url: 'trChangeBooks/all',
        }).then(function(response) {
            init.allDataTrChangeBooks = response.data;
        }, function(response) {});
    }

    init.addCart = function(input) {
        console.log("Inputan Penjualan", input);
        return $http({
            method: 'POST',
            url: 'trChangeBooks/cartAdd',
            data: {
                barcode_box: input.item.barcode_box
                , barcode_strip: input.item.barcode_strip
                , created_at: input.item.created_at
                , id: input.item.id
                , name: input.item.name
                , note: input.item.note
                , percent_profit_per_box: input.item.percent_profit_per_box
                , percent_profit_per_strip: input.item.percent_profit_per_strip
                , percent_profit_per_tablet: input.item.percent_profit_per_tablet
                , price_purchase_per_box: input.item.price_purchase_per_box
                , price_purchase_per_strip: input.item.price_purchase_per_strip
                , price_purchase_per_tablet: input.item.price_purchase_per_tablet
                , price_sell_per_box: input.item.price_sell_per_box
                , price_sell_per_strip: input.item.price_sell_per_strip
                , price_sell_per_tablet: input.item.price_sell_per_tablet
                , qty_in_bottle: input.item.qty_in_bottle
                , qty_in_box: input.item.qty_in_box
                , qty_in_strip: input.item.qty_in_strip
                , qty_in_tablet: input.item.qty_in_tablet
                , qty_min: input.item.qty_min
                , qty_total: input.item.qty_total
                , sku: input.item.sku
            },
        }).then(function(response) {
            init.resDataCart = response.data;
        }, function(response) {});
    }

    // Search Item
    init.getDataItem = function(input) {
        return $http({
            method: 'GET',
            url: 'trChangeBooks/searchItemManual/' + input.item_id
        }).then(function(response) {
            init.resDataItem = response.data;
        }, function(response) {});
    }

    init.printLastTrSales = function() {
        return $http({
            method: 'GET',
            url: 'trChangeBooks/printLastTrSales'
        }).then(function(response) {
            console.log(response.data);
            init.resLastTrSales = response.data;
        }, function(response) {});
    }

    init.deleteTrChangeBooks = function (input) {
        // console.log(input.tr_change_book_id);
        
        return $http({
            method: 'GET',
            url: 'trChangeBooks/delete/' + input.tr_change_book_id
        }).then(function (response) {
            init.dataTrChangeBooksDetail = response.data;
        }, function (response) {
            console.log("Error");
        });
    }

    return init;
})
