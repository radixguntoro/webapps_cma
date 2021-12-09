var app = angular.module('categoryCtrl', ['factoryCategory']);

app.controller('categoryController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $state, toastr, hotkeys, categoryFactory) {
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

    $scope.category = {};

    //##############################//
    //  LIST, PAGINATION & SEARCH   //
    //##############################//
    $scope.getResultsPage = function(pageNumber) {
        $scope.loading = true;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            categoryFactory.searchDataCategory(pageNumber, $scope.searchText)
                .then(function() {
                    $scope.data = categoryFactory.resultData;
                    $scope.totalItems = categoryFactory.totalItems;
                    $scope.loading = false;
                });
        } else {
            categoryFactory.getDataCategory(pageNumber)
                .then(function() {
                    $scope.data = categoryFactory.resultData;
                    $scope.totalItems = categoryFactory.totalItems;
                    $scope.loading = false;
                    console.log($scope.data);
                });
        }
    }

    $scope.pageChanged = function(newPage) {
        $scope.getResultsPage(newPage);
    };

    $scope.getResultsPage(1);

    $scope.searchData = function() {
        if ($scope.searchText.length >= 3) {
            if ($.isEmptyObject($scope.libraryTemp)) {
                $scope.libraryTemp = $scope.data;
                $scope.totalItemsTemp = $scope.totalItems;
                $scope.data = {};
            }
            $scope.getResultsPage(1);
        } else {
            if (!$.isEmptyObject($scope.libraryTemp)) {
                $scope.data = $scope.libraryTemp;
                $scope.totalItems = $scope.totalItemsTemp;
                $scope.libraryTemp = {};
                $scope.getResultsPage(1);
            }
        }
    }

    //##############################//
    //      FUNGSI CREATE DATA      //
    //##############################//
    $scope.createData = function() {
        if ($scope.category.name == null) {
            toastr.error('Category name is required', 'Failed!');
            return true;
        } else {
            angular.element('#btn-save').attr('disabled', true);
            categoryFactory.insertDataCategory({
                category: $scope.category
            }).then(function() {
                $state.go("category-list");
                angular.element('#btn-save').attr('disabled', false);
            });
        }
    }

    //##############################//
    //       FUNGSI EDIT DATA       //
    //##############################//
    if ($state.current.name == "category-edit") {
        $scope.category = {};
        categoryFactory.getDataEachCategory($stateParams.id)
            .then(function() {
                $scope.category = categoryFactory.eachDataCategory;
            });

        $scope.updateData = function() {
            if ($scope.category.name == null) {
                toastr.error('Category name is required', 'Failed!');
                return true;
            } else {
                angular.element('#btn-save').attr('disabled', true);
                categoryFactory.updateDataCategory({
                    id: $stateParams.id,
                    category: $scope.category
                }).then(function() {
                    $state.go("category-list");
                    angular.element('#btn-save').attr('disabled', false);
                });
            }
        }
    }

    //##############################//
    //       FUNGSI HAPUS DATA      //
    //##############################//
    $scope.deleteDataCategory = function(data) {
        categoryFactory.deleteDataCategory({
            id: data.id
        }).then(function() {
            $state.go($state.current, {}, {
                reload: true
            });
        });
    }
})
