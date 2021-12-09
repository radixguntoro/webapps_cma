var app = angular.module('factoryTrChangeStamps', []);
app.factory('trChangeStampsFactory', function($http, toastr) {
    var init = {};
    init.data = {};
    init.resultData = [];
    init.dataTrChangeStamps = [];
    init.totalItems = [];
    init.eachDataTrChangeStamps = [];
    var input = {};

    // Pagination and Search Function
    init.searchDataTrChangeStamps = function(pageNumber, searchText) {
        return $http({
            method: 'GET',
            url: 'trChangeStamps/list?search=' + searchText + '&page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.getDataTrChangeStamps = function(pageNumber) {
        return $http({
            method: 'GET',
            url: 'trChangeStamps/list?page=' + pageNumber
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    }

    init.filterDataTrChangeStamps = function(pageNumber, dateStart, dateEnd) {
        return $http({
            method: 'GET',
            url: 'trChangeStamps/list?page=' + pageNumber + '&datestart=' + dateStart + '&dateend=' + dateEnd
        }).then(function(response) {
            init.resultData = response.data.data;
            init.totalItems = response.data.total;
        }, function(response) {});
    };

    init.insertDataTrChangeStamps = function(input) {
        console.log(input);
        return $http({
            method: 'POST',
            url: 'trChangeStamps/insert',
            data: {
                date: input.tr_changestamps.date
                , note: input.tr_changestamps.note
                , student_id: input.student.id
                , cart_item: input.cart_item
            },
        }).then(function(response) {
           toastr.success('Data has been saved', 'Success!');
        }, function(response) {
            toastr.error('Data failed to save', 'Failed!');
        });
    }

    init.getDataEachTrChangeStamps = function(input) {
        return $http({
            method: 'GET',
            url: 'trChangeStamps/edit/' + input,
        }).then(function(response) {
            init.eachDataTrChangeStamps = response.data;
        }, function(response) {});
    }

    init.updateDataTrChangeStamps = function(input) {
        return $http({
            method: 'POST',
            url: 'trChangeStamps/update/' + input.id,
            data: {
                name: input.trChangeStamps.name,
                parent_id: input.trChangeStamps_parent,
                status: input.trChangeStamps_status
            }
        }).then(function(response) {
            toastr.success('Data has been changed', 'Success!');
        }, function(response) {
            toastr.error('Data failed to change', 'Failed!');
        });
    }

    init.getAllDataTrChangeStamps = function() {
        return $http({
            method: 'GET',
            url: 'trChangeStamps/all',
        }).then(function(response) {
            init.allDataTrChangeStamps = response.data;
        }, function(response) {});
    }

    // Search Item
    init.getDataStamp = function(input) {
        return $http({
            method: 'GET',
            url: 'trChangeStamps/searchStamp/' + input.item_id
        }).then(function(response) {
            init.resDataStamp = response.data;
        }, function(response) {});
    }

    init.printLastTrSales = function() {
        return $http({
            method: 'GET',
            url: 'trChangeStamps/printLastTrSales'
        }).then(function(response) {
            console.log(response.data);
            init.resLastTrSales = response.data;
        }, function(response) {});
    }

    return init;
})
