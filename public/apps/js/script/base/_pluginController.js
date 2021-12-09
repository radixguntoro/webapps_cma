var app = angular.module('pluginCtrl', []);

app.controller('pluginController', function($scope, $timeout, $window, $location, $state, hotkeys, itemFactory) {

    $scope.todayDate = new Date();
    $scope.countNotif = 1;
    $scope.user_id = angular.element('#user_id').val();

    if ($scope.user_id != 1) {
        // Key Master
        hotkeys.add({
            combo: 'ctrl+1',
            allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
            callback: function(event, hotkey) {
                $state.go('item-list');
            }
        });
        if ($scope.user_id == 99 || $scope.user_id == 0) {
            hotkeys.add({
                combo: 'ctrl+2',
                allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
                callback: function(event, hotkey) {
                    $state.go('user-list');
                }
            });
        }
        if ($scope.user_id == 99 || $scope.user_id == 0 || $scope.user_id == 2) {
            hotkeys.add({
                combo: 'ctrl+3',
                allowIn: ['INPUT', 'SELECT', 'TEXTAREA'],
                callback: function(event, hotkey) {
                    $state.go('supplier-list');
                }
            });
        }
    }

    // GLOBAL SORT COLUMN

});
