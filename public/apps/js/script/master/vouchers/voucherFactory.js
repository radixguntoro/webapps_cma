var app = angular.module('factoryVoucher', []);
app.factory('voucherFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataVoucher = [];
    init.totalVouchers = [];
    init.eachDataVoucher = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataVoucher = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'voucher/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalVouchers = response.data.total;
        }, function(response) {});
    };

    init.getDataVoucher = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'voucher/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalVouchers = response.data.total;
        }, function(response) {});
    }

    init.insertDataVoucher = function(input) {
        // console.log("inputan", input);
        return $http({
            method: 'POST',
            url: 'voucher/insert',
            data: {
                name: input.voucher.name,
                price: input.voucher.price,
                qty: input.voucher.qty,
                status: input.status,
            },
        }).then(function(response) {
            toastr.success('Data has been saved', 'Success!');
        }, function(response) {
            toastr.error('Data failed to save', 'Failed!');
        });
    }

    init.getDataEachVoucher = function(input) {
        return $http({
            method: 'GET',
            url: 'voucher/edit/' + input,
        }).then(function(response) {
            init.eachDataVoucher = response.data;
        }, function(response) {});
    }

    init.updateDataVoucher = function(input) {
        return $http({
            method: 'POST',
            url: 'voucher/update/' + input.id,
            data: {
                name: input.voucher.name,
                price: input.voucher.price,
                qty: input.voucher.qty,
                status: input.status,
            },
        }).then(function(response) {
            toastr.success('Data has been saved', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    // Get Voucher Detail
    init.showVoucherDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'voucher/detail/' + input.voucher_id
        }).then(function(response) {
            init.dataVoucherDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    // Search Voucher Manual
    init.searchVoucherManual = function(searchText) {
        return $http({
            method: 'GET',
            url: 'voucher/manual?search=' + searchText.typo
        }).then(function(response) {
            init.resSearchVoucher = response.data.data;
        }, function(response) {});
    }

    init.getAllDataVoucher = function() {
        return $http({
            method: 'GET',
            url: 'voucher/all',
        }).then(function(response) {
            init.allDataVoucher = response.data;
        }, function(response) {});
    }

    init.getMinStockVoucher = function() {
        return $http({
            method: 'GET',
            url: 'voucher/min-stock',
        }).then(function(response) {
            init.minStockVoucher = response.data;
        }, function(response) {});
    }

    return init;
})
