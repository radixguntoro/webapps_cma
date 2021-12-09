var app = angular.module('userCtrl', ['factoryUser']);

app.controller('userController', function($rootScope, $scope, $stateParams, $window, $timeout, $location, $http, $filter, $state, toastr, hotkeys, userFactory) {
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

    $scope.gender = "P";
    $scope.status = "A";

    $scope.user = {
        name: ''
        , join_date: $filter('date')(new Date(), 'yyyy-MM-dd')
    };

    $scope.dateReportOptions = {
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    };

    $scope.permissions = [{ id: 3, name: "Teacher"}, {id: 2, name: "Customer Service"}, {id: 1, name: "Owner"}];
    $scope.permission = $scope.permissions[0];

    //##############################//
    //  LIST, PAGINATION & SEARCH   //
    //##############################//
    $scope.getResultsPage = function(pageNumber) {
        $scope.loading = true;
        if (!$.isEmptyObject($scope.libraryTemp)) {
            userFactory.searchDataUser(pageNumber, $scope.searchText)
                .then(function() {
                    $scope.data = userFactory.resultData;
                    $scope.totalItems = userFactory.totalItems;
                    $scope.loading = false;
                });
        } else {
            userFactory.getDataUser(pageNumber)
                .then(function() {
                    $scope.data = userFactory.resultData;
                    $scope.totalItems = userFactory.totalItems;
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
        $scope.loading = true;
        if ($scope.user.name == null) {
            toastr.error('User name is required', 'Failed!');
            return true;
        } else {
            angular.element('#btn-save').attr('disabled', true);
            userFactory.insertDataUser({
                user: $scope.user,
                permission: $scope.permission.id,
                status: $scope.status,
            }).then(function() {
                $state.go("user-list");
                angular.element('#btn-save').attr('disabled', false);
                $scope.loading = false;
            });
        }
    }

    //##############################//
    //       FUNGSI EDIT DATA       //
    //##############################//
    if ($state.current.name == "user-edit") {
        $scope.user = {};
        userFactory.getDataEachUser($stateParams.id)
            .then(function() {
                $scope.user = userFactory.eachDataUser;
                $scope.status = userFactory.eachDataUser.status;
                $scope.permission = userFactory.eachDataUser.permission;
                angular.forEach($scope.permissions, function(value, key){
                    if(value.id == $scope.permission) {
                        $scope.permission = value;
                    }
                });
            });

        $scope.updateData = function() {
            $scope.loading = true;
            if ($scope.user.name == null) {
                toastr.error('User name is required', 'Failed!');
                return true;
            } else {
                angular.element('#btn-save').attr('disabled', true);
                userFactory.updateDataUser({
                    id: $stateParams.id,
                    user: $scope.user,
                    permission: $scope.permission.id,
                    status: $scope.status
                }).then(function() {
                    $state.go("user-list");
                    angular.element('#btn-save').attr('disabled', false);
                    $scope.loading = false;
                });
            }
        }
    }

    //##############################//
    //       FUNGSI HAPUS DATA      //
    //##############################//
    $scope.deleteDataUser = function(data) {
        userFactory.deleteDataUser({
            id: data.id
        }).then(function() {
            $state.go($state.current, {}, {
                reload: true
            });
        });
    }

    //##############################//
    //      FUNGSI DETAIL DATA      //
    //##############################//
    $scope.showUserDetail = function(user) {
        $scope.loadingDetail = true;
        userFactory.showUserDetail({
            user_id: user.id
        }).then(function() {
            $scope.user_detail = userFactory.dataUserDetail.data_user;
            console.log($scope.user_detail);
            $scope.loadingDetail = false;
        });
    }

    //##############################//
    //    HOTKEYS FORM PENJUALAN    //
    //##############################//
    if ($state.current.name == 'user-list') {
        $scope.helpShow = false;
        $scope.helpPanel = function(flag) {
            if (flag) {
                $scope.helpShow = false;
            } else {
                $scope.helpShow = true;
            }
        }
        angular.element('#inp-search').focus();
        hotkeys.add({
            combo: 'alt+h',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $timeout(function() {
                    angular.element('#btn-help').triggerHandler('click');
                }, 0);
            }
        });

        hotkeys.add({
            combo: 'alt+t',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $state.go('user-create');
            }
        });

        hotkeys.add({
            combo: 'alt+f',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                angular.element('#inp-search').focus();
            }
        });

        return true;
    }

    if ($state.current.name == 'user-create') {
        $scope.helpShow = false;
        $scope.helpPanel = function(flag) {
            if (flag) {
                $scope.helpShow = false;
            } else {
                $scope.helpShow = true;
            }
        }
        hotkeys.add({
            combo: 'alt+h',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $timeout(function() {
                    angular.element('#btn-help').triggerHandler('click');
                }, 0);
            }
        });
        angular.element('#user-name').focus();
        hotkeys.add({
            combo: 'ctrl+d',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                angular.element('#barcode-box').focus();
                return true;
            }
        });
        hotkeys.add({
            combo: 'alt+d',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                angular.element('#barcode-strip').focus();
                return true;
            }
        });
        hotkeys.add({
            combo: 'alt+s',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                if ($scope.loading == true) {
                    return true;
                } else {
                    $scope.createData();
                }
            }
        });
        hotkeys.add({
            combo: 'esc',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $state.go('user-list');
            }
        });
        return true;
    }

    if ($state.current.name == "user-edit") {
        angular.element('#user-name').focus();
        $scope.helpShow = false;
        $scope.helpPanel = function(flag) {
            if (flag) {
                $scope.helpShow = false;
            } else {
                $scope.helpShow = true;
            }
        }
        hotkeys.add({
            combo: 'alt+h',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $timeout(function() {
                    angular.element('#btn-help').triggerHandler('click');
                }, 0);
            }
        });
        hotkeys.add({
            combo: 'ctrl+d',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                angular.element('#barcode-box').focus();
                return true;
            }
        });
        hotkeys.add({
            combo: 'alt+d',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                angular.element('#barcode-strip').focus();
                return true;
            }
        });
        hotkeys.add({
            combo: 'alt+s',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                event.preventDefault();
                if ($scope.loading == true) {
                    return true;
                } else {
                    $scope.updateData();
                }
            }
        });
        hotkeys.add({
            combo: 'esc',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $state.go('user-list');
            }
        });
        return true;
    }
})
