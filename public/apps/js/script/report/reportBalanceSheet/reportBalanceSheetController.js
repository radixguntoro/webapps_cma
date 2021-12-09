var app = angular.module('reportBalanceSheetCtrl', ['factoryReportBalanceSheet']);

app.controller('reportBalanceSheetController', function($rootScope, $scope, $stateParams, $timeout, $location, $http, $state, $filter, $window, toastr, reportBalanceSheetFactory) {
    $rootScope.$state = $state;
    $scope.now_year = $filter('date')(new Date(), 'yyyy');
    $scope.loading = true;
    reportBalanceSheetFactory.getCountData()
        .then(function() {
            $scope.count_student_active = reportBalanceSheetFactory.resultData.data.count_student_active;
            $scope.count_student_nonactive = reportBalanceSheetFactory.resultData.data.count_student_nonactive;
            $scope.deposit_student_active = reportBalanceSheetFactory.resultData.data.deposit_student_active;
            $scope.deposit_student_nonactive = reportBalanceSheetFactory.resultData.data.deposit_student_nonactive;
            $scope.count_reward_active = reportBalanceSheetFactory.resultData.data.count_reward_active;
            $scope.count_reward_nonactive = reportBalanceSheetFactory.resultData.data.count_reward_nonactive;
            $scope.price_reward_active = reportBalanceSheetFactory.resultData.data.price_reward_active;
            $scope.price_reward_nonactive = reportBalanceSheetFactory.resultData.data.price_reward_nonactive;
            $scope.chart_payments = reportBalanceSheetFactory.resultData.data.chart_payments;
            $scope.count_voucher_active = reportBalanceSheetFactory.resultData.data.count_voucher_active;
            $scope.count_voucher_nonactive = reportBalanceSheetFactory.resultData.data.count_voucher_nonactive;
            $scope.value_voucher_active = reportBalanceSheetFactory.resultData.data.value_voucher_active;
            $scope.value_voucher_nonactive = reportBalanceSheetFactory.resultData.data.value_voucher_nonactive;
            $scope.inventory_book_qty_active = reportBalanceSheetFactory.resultData.data.inventory_book_qty_active;
            $scope.inventory_book_qty_nonactive = reportBalanceSheetFactory.resultData.data.inventory_book_qty_nonactive;
            $scope.inventory_book_selling_active = reportBalanceSheetFactory.resultData.data.inventory_book_selling_active;
            $scope.inventory_book_selling_nonactive = reportBalanceSheetFactory.resultData.data.inventory_book_selling_nonactive;
            $scope.inventory_book_buying_active = reportBalanceSheetFactory.resultData.data.inventory_book_buying_active;
            $scope.inventory_book_buying_nonactive = reportBalanceSheetFactory.resultData.data.inventory_book_buying_nonactive;
            $scope.inventory_accessory_qty_active = reportBalanceSheetFactory.resultData.data.inventory_accessory_qty_active;
            $scope.inventory_accessory_qty_nonactive = reportBalanceSheetFactory.resultData.data.inventory_accessory_qty_nonactive;
            $scope.inventory_accessory_selling_active = reportBalanceSheetFactory.resultData.data.inventory_accessory_selling_active;
            $scope.inventory_accessory_selling_nonactive = reportBalanceSheetFactory.resultData.data.inventory_accessory_selling_nonactive;
            $scope.inventory_accessory_buying_active = reportBalanceSheetFactory.resultData.data.inventory_accessory_buying_active;
            $scope.inventory_accessory_buying_nonactive = reportBalanceSheetFactory.resultData.data.inventory_accessory_buying_nonactive;
            $scope.loading = false;
        });

    //##############################//
    //      FUNGSI EXPORT EXCEL     //
    //##############################//
    $scope.exportExcel = function() {
        var url = 'reportBalanceSheet/exportExcel';
        $window.open(url);
    }
})
