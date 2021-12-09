var app = angular.module('factoryTrStockOpname', []);
app.factory('trStockOpnameFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataTrStockOpname = [];
    init.totalItems = [];
    init.eachDataTrStockOpname = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataTrStockOpname = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'trStockOpname/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataTrStockOpname = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'trStockOpname/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.insertDataTrStockOpname = function(input) {
        console.log(input);
        return $http({
            method: 'POST',
            url: 'trStockOpname/insert',
            data: {
                price_purchase_app: input.tr_stock_opname.price_purchase_app,
                price_purchase_phx: input.tr_stock_opname.price_purchase_phx,
                price_purchase_difference: input.tr_stock_opname.price_purchase_difference,
                price_sell_app: input.tr_stock_opname.price_sell_app,
                price_sell_phx: input.tr_stock_opname.price_sell_phx,
                price_sell_difference: input.tr_stock_opname.price_sell_difference,
                item_code: input.tr_stock_opname.item_id,
                stock_in_system: input.tr_stock_opname.stock_in_system,
                stock_in_physic: input.tr_stock_opname.stock_in_physic,
                stock_difference: input.tr_stock_opname.stock_difference,
                status: "proses"
            },
        }).then(function(response) {
            toastr.success('Data berhasil disimpan', 'Sukses!');
        }, function(response) {
            toastr.error('Data gagal disimpan', 'Gagal!');
        });
    }

    init.createData = function(input) {
        console.log("Data Insert", input);
		return $http({
            method: 'POST',
            url: 'trStockOpname/insert',
            data: {
                cart_item: input.cart_item
            },
        }).then(function(response) {
            toastr.success('Data has been saved', 'Success!');
        }, function(response) {
            toastr.error('Data failed to save', 'Failed!');
        });
    }

    init.getDataItem = function(input) {
        return $http({
            method: 'GET',
            url: 'trStockOpname/getItem/' + input.tr_stock_opname.item_id
        }).then(function(response) {
            init.resDataItem = response.data;
        }, function(response) {});
    }

    return init;
})
