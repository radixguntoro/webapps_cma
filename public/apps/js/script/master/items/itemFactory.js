var app = angular.module('factoryItem', []);
app.factory('itemFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataItem = [];
    init.totalItems = [];
    init.eachDataItem = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataItem = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'item/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataItem = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'item/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.insertDataItem = function(input) {
        // console.log("inputan", input);
        return $http({
            method: 'POST',
            url: 'item/insert',
            data: {
                name: input.item.name,
                qty: input.item.qty,
                price_buy: input.item.price_buy,
                price_sell: input.item.price_sell,
                price_starter_kids: input.item.price_starter_kids,
                category_id: input.category_id,
                status: input.status,
                starter_kids: input.starter_kids
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

    init.getDataEachItem = function(input) {
        return $http({
            method: 'GET',
            url: 'item/edit/' + input,
        }).then(function(response) {
            init.eachDataItem = response.data;
        }, function(response) {});
    }

    init.updateDataItem = function(input) {
        return $http({
            method: 'POST',
            url: 'item/update/' + input.id,
            data: {
                name: input.item.name,
                qty: input.item.qty,
                price_buy: input.item.price_buy,
                price_sell: input.item.price_sell,
                price_starter_kids: input.item.price_starter_kids,
                category_id: input.category_id,
                status: input.status,
                starter_kids: input.starter_kids
            },
        }).then(function(response) {
            toastr.success('Data has been changed', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Gagal!');
        });
    }

    // Get Item Detail
    init.showItemDetail = function(input) {
        return $http({
            method: 'GET',
            url: 'item/detail/' + input.item_id
        }).then(function(response) {
            init.dataItemDetail = response.data;
        }, function(response) {
            console.log("Error");
        });
    }

    // Search Item Manual
    init.searchItemManual = function(searchText) {
        return $http({
            method: 'GET',
            url: 'item/manual?search=' + searchText.typo
        }).then(function(response) {
            init.resSearchItem = response.data.data;
        }, function(response) {});
    }

    init.searchBookOnly = function(searchText) {
        return $http({
            method: 'GET',
            url: 'item/book?search=' + searchText.typo
        }).then(function(response) {
            init.resSearchItem = response.data.data;
        }, function(response) {});
    }

    init.getAllDataItem = function() {
        return $http({
            method: 'GET',
            url: 'item/all',
        }).then(function(response) {
            init.allDataItem = response.data;
        }, function(response) {});
    }

    init.getMinStockItem = function() {
        return $http({
            method: 'GET',
            url: 'item/min-stock',
        }).then(function(response) {
            init.minStockItem = response.data;
        }, function(response) {});
    }

    // Search Item All
    init.searchItemAll = function(searchText) {
        return $http({
            method: 'GET',
            url: 'item/all?search=' + searchText.typo
        }).then(function(response) {
            init.resSearchItemAll = response.data;
        }, function(response) {});
    }

    // Get Starter Kits
    init.getStarterKids = function(input) {
        console.log(input);
        return $http({
            method: 'GET',
            url: 'item/getStarterKids/'+ input.starter_kids,
        }).then(function(response) {
            init.allDataStarterKids = response.data;
            console.log(init.allDataStarterKids);
        }, function(response) {});
    }

    return init;
})
