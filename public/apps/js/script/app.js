var app = angular.module('desktopApps', [
    // Inject Plugin
    'angularUtils.directives.dirPagination'
    , 'angular.filter'
    , 'pluginCtrl'
    // , 'notifCtrl'
    , 'pluginDrtv'
    , 'hl.sticky'
    , 'toastr'
    , 'ui.router'
    , 'ngAnimate'
    // , 'angular-loading-bar'
    , 'scanner.detection'
    , 'ui.select'
    , 'ngSanitize'
    , 'angularFileUpload'
    , 'ui.utils.masks'
    , 'toggles'
    , 'ui.autocomplete'
    , 'ui.tinymce'
    , 'ngTabs'
    , 'cfp.hotkeys'
    , 'ui.date'
    , 'chart.js'
    , 'dashboardCtrl'
    , 'categoryCtrl'
    , 'studentCtrl'
    , 'itemCtrl'
    , 'tuitionCtrl'
    , 'stampCtrl'
    , 'userCtrl'
    , 'voucherCtrl'
    , 'trPaymentsCtrl'
    , 'trChangeBooksCtrl'
    , 'trChangeStampsCtrl'
    , 'trPurchaseOrdersCtrl'
    , 'trPurchaseOrderStampsCtrl'
    , 'trStockOpnameCtrl'
    , 'reportTrPaymentsCtrl'
    , 'reportTrChangeBooksCtrl'
    , 'reportTrChangeStampsCtrl'
    , 'reportItemsCtrl'
    , 'reportDepositBooksCtrl'
    , 'reportStockGiftRewardsCtrl'
    , 'reportStudentLastBooksCtrl'
    , 'reportStockOpnameCtrl'
    , 'reportTrPaymentStudentsCtrl'
    , 'reportNewStudentsCtrl'
    , 'reportPurchaseOrdersCtrl'
    , 'reportPurchaseOrderRewardsCtrl'
    , 'reportStockOpnameCtrl'
    , 'reportStockOpnameRewardCtrl'
    , 'reportBalanceSheetCtrl'
    , 'reportIncomeStatementCtrl'
    , 'historyLoginCtrl'
    , 'historyTrChangeBooksCtrl'
    , 'historyTrChangeStampsCtrl'
    , 'historyTrPaymentsCtrl'
    , 'historyTrPurchaseOrdersCtrl'
    , 'historyTrPurchaseOrderStampsCtrl'
    , 'historyTrStockOpnameCtrl'
    , 'databaseCtrl'
]);

app.run(function($rootScope, $timeout, $window) {
    $rootScope
        .$on('$stateChangeStart',
            function(event, $scope, toState, toParams, fromState, fromParams) {
                // angular.element(".vs-box-page-content").css("display", "none");
                angular.element(".vs-adm-loader").css("display", "block");
                $window.scrollTo(0, 0);
            });

    $rootScope
        .$on('$stateChangeSuccess',
            function(event, toState, toParams, fromState, fromParams) {
                // angular.element(".vs-box-page-content").css("display", "block");
                angular.element(".vs-adm-loader").css("display", "none");
            });

    $rootScope.$apply($(document).foundation());

}).config(function($locationProvider, $urlRouterProvider, $stateProvider, $interpolateProvider, toastrConfig) {
    // Configuration Toastr
    angular.extend(toastrConfig, {
        autoDismiss: false,
        containerId: 'toast-container',
        maxOpened: 0,
        newestOnTop: true,
        positionClass: 'toast-top-right',
        preventDuplicates: false,
        preventOpenDuplicates: false,
        target: 'body'
    });

    // Configuration Routes
    $stateProvider
        .state('dashboard', {
            url: '/',
            templateUrl: '../resources/views/templates/apps/dashboard/dashboard.html',
            controller: 'dashboardController'
        }).state('tr-payment-create', {
            url: '/tr-payment-create',
            templateUrl: '../resources/views/templates/apps/transaction/trPayments/trPaymentsCreate.html',
            controller: 'trPaymentsController'
        }).state('tr-changebook-create', {
            url: '/tr-changebook-create',
            templateUrl: '../resources/views/templates/apps/transaction/trChangeBooks/trChangeBooksCreate.html',
            controller: 'trChangeBooksController'
        }).state('tr-changebook-list', {
            url: '/tr-changebook-list',
            templateUrl: '../resources/views/templates/apps/transaction/trChangeBooks/trChangeBooksList.html',
            controller: 'trChangeBooksController'
        }).state('tr-changestamp-create', {
            url: '/tr-changestamp-create',
            templateUrl: '../resources/views/templates/apps/transaction/trChangeStamps/trChangeStampsCreate.html',
            controller: 'trChangeStampsController'
        }).state('tr-purchase-order-create', {
            url: '/tr-purchase-order-create',
            templateUrl: '../resources/views/templates/apps/transaction/trPurchaseOrders/trPurchaseOrdersCreate.html',
            controller: 'trPurchaseOrdersController'
        }).state('tr-purchase-order-edit', {
            url: '/tr-purchase-order-edit/:id',
            templateUrl: '../resources/views/templates/apps/transaction/trPurchaseOrders/trPurchaseOrdersEdit.html',
            controller: 'trPurchaseOrdersController'
        }).state('tr-purchase-order-stamp-create', {
            url: '/tr-purchase-order-stamp-create',
            templateUrl: '../resources/views/templates/apps/transaction/trPurchaseOrderStamps/trPurchaseOrderStampsCreate.html',
            controller: 'trPurchaseOrderStampsController'
        }).state('tr-stock-opname', {
            url: '/tr-stock-opname',
            templateUrl: '../resources/views/templates/apps/inventory/trStockOpname/trStockOpname.html',
            controller: 'trStockOpnameController'
        }).state('item-list', {
            url: '/item-list',
            templateUrl: '../resources/views/templates/apps/master/items/itemList.html',
            controller: 'itemController'
        }).state('item-create', {
            url: '/item-create',
            templateUrl: '../resources/views/templates/apps/master/items/itemCreate.html',
            controller: 'itemController'
        }).state('item-edit', {
            url: '/item-edit/:id',
            templateUrl: '../resources/views/templates/apps/master/items/itemEdit.html',
            controller: 'itemController'
        }).state('category-list', {
            url: '/category-list',
            templateUrl: '../resources/views/templates/apps/master/categories/categoryList.html',
            controller: 'categoryController'
        }).state('category-create', {
            url: '/category-create',
            templateUrl: '../resources/views/templates/apps/master/categories/categoryCreate.html',
            controller: 'categoryController'
        }).state('category-edit', {
            url: '/category-edit/:id',
            templateUrl: '../resources/views/templates/apps/master/categories/categoryEdit.html',
            controller: 'categoryController'
        }).state('user-list', {
            url: '/user-list',
            templateUrl: '../resources/views/templates/apps/master/users/userList.html',
            controller: 'userController'
        }).state('user-create', {
            url: '/user-create',
            templateUrl: '../resources/views/templates/apps/master/users/userCreate.html',
            controller: 'userController'
        }).state('user-edit', {
            url: '/user-edit/:id',
            templateUrl: '../resources/views/templates/apps/master/users/userEdit.html',
            controller: 'userController'
        }).state('student-list', {
            url: '/student-list',
            templateUrl: '../resources/views/templates/apps/master/students/studentList.html',
            controller: 'studentController'
        }).state('student-create', {
            url: '/student-create',
            templateUrl: '../resources/views/templates/apps/master/students/studentCreate.html',
            controller: 'studentController'
        }).state('student-edit', {
            url: '/student-edit/:id',
            templateUrl: '../resources/views/templates/apps/master/students/studentEdit.html',
            controller: 'studentController'
        }).state('tuition-list', {
            url: '/tuition-list',
            templateUrl: '../resources/views/templates/apps/master/tuitions/tuitionList.html',
            controller: 'tuitionController'
        }).state('tuition-create', {
            url: '/tuition-create',
            templateUrl: '../resources/views/templates/apps/master/tuitions/tuitionCreate.html',
            controller: 'tuitionController'
        }).state('tuition-edit', {
            url: '/tuition-edit/:id',
            templateUrl: '../resources/views/templates/apps/master/tuitions/tuitionEdit.html',
            controller: 'tuitionController'
        }).state('stamp-list', {
            url: '/stamp-list',
            templateUrl: '../resources/views/templates/apps/master/stamps/stampList.html',
            controller: 'stampController'
        }).state('stamp-create', {
            url: '/stamp-create',
            templateUrl: '../resources/views/templates/apps/master/stamps/stampCreate.html',
            controller: 'stampController'
        }).state('stamp-edit', {
            url: '/stamp-edit/:id',
            templateUrl: '../resources/views/templates/apps/master/stamps/stampEdit.html',
            controller: 'stampController'
        }).state('voucher-list', {
            url: '/voucher-list',
            templateUrl: '../resources/views/templates/apps/master/vouchers/voucherList.html',
            controller: 'voucherController'
        }).state('voucher-create', {
            url: '/voucher-create',
            templateUrl: '../resources/views/templates/apps/master/vouchers/voucherCreate.html',
            controller: 'voucherController'
        }).state('voucher-edit', {
            url: '/voucher-edit/:id',
            templateUrl: '../resources/views/templates/apps/master/vouchers/voucherEdit.html',
            controller: 'voucherController'
        }).state('rep-tr-payments', {
            url: '/rep-tr-payments',
            templateUrl: '../resources/views/templates/apps/report/repTrPayments/repTrPaymentsList.html',
            controller: 'reportTrPaymentsController'
        }).state('rep-tr-change-books', {
            url: '/rep-tr-change-books',
            templateUrl: '../resources/views/templates/apps/report/repTrChangeBooks/repTrChangeBooksList.html',
            controller: 'reportTrChangeBooksController'
        }).state('rep-tr-change-stamps', {
            url: '/rep-tr-change-stamps',
            templateUrl: '../resources/views/templates/apps/report/repTrChangeStamps/repTrChangeStampsList.html',
            controller: 'reportTrChangeStampsController'
        }).state('rep-items', {
            url: '/rep-items',
            templateUrl: '../resources/views/templates/apps/report/repItems/repItemsList.html',
            controller: 'reportItemsController'
        }).state('rep-deposit-books', {
            url: '/rep-deposit-books',
            templateUrl: '../resources/views/templates/apps/report/repDepositBooks/repDepositBooksList.html',
            controller: 'reportDepositBooksController'
        }).state('rep-stock-gift-rewards', {
            url: '/rep-stock-gift-rewards',
            templateUrl: '../resources/views/templates/apps/report/repStockGiftRewards/repStockGiftRewardsList.html',
            controller: 'reportStockGiftRewardsController'
        }).state('rep-student-last-books', {
            url: '/rep-student-last-books',
            templateUrl: '../resources/views/templates/apps/report/repStudentLastBooks/repStudentLastBooksList.html',
            controller: 'reportStudentLastBooksController'
        }).state('rep-tr-payment-students', {
            url: '/rep-tr-payment-students',
            templateUrl: '../resources/views/templates/apps/report/repTrPaymentStudents/repTrPaymentStudentsList.html',
            controller: 'reportTrPaymentStudentsController'
        }).state('rep-new-students', {
            url: '/rep-new-students',
            templateUrl: '../resources/views/templates/apps/report/repNewStudents/repNewStudentsList.html',
            controller: 'reportNewStudentsController'
        }).state('rep-purchase-orders', {
            url: '/rep-purchase-orders',
            templateUrl: '../resources/views/templates/apps/report/repPurchaseOrders/repPurchaseOrdersList.html',
            controller: 'reportPurchaseOrdersController'
        }).state('rep-purchase-order-rewards', {
            url: '/rep-purchase-order-rewards',
            templateUrl: '../resources/views/templates/apps/report/repPurchaseOrderRewards/repPurchaseOrderRewardsList.html',
            controller: 'reportPurchaseOrderRewardsController'
        }).state('rep-stock-opname', {
            url: '/rep-stock-opname',
            templateUrl: '../resources/views/templates/apps/report/repStockOpname/repStockOpnameList.html',
            controller: 'reportStockOpnameController'
        }).state('rep-stock-opname-reward', {
            url: '/rep-stock-opname-reward',
            templateUrl: '../resources/views/templates/apps/report/repStockOpnameReward/repStockOpnameRewardList.html',
            controller: 'reportStockOpnameRewardController'
        }).state('rep-balance-sheet', {
            url: '/rep-balance-sheet',
            templateUrl: '../resources/views/templates/apps/report/repBalanceSheet/repBalanceSheetList.html',
            controller: 'reportBalanceSheetController'
        }).state('rep-income-statement', {
            url: '/rep-income-statement',
            templateUrl: '../resources/views/templates/apps/report/repIncomeStatement/repIncomeStatementList.html',
            controller: 'reportIncomeStatementController'
        }).state('his-login', {
            url: '/his-login',
            templateUrl: '../resources/views/templates/apps/history/hisLogin/hisLoginList.html',
            controller: 'historyLoginController'
        }).state('his-tr-change-books', {
            url: '/his-tr-change-books',
            templateUrl: '../resources/views/templates/apps/history/hisTrChangeBooks/hisTrChangeBooksList.html',
            controller: 'historyTrChangeBooksController'
        }).state('his-tr-change-stamps', {
            url: '/his-tr-change-stamps',
            templateUrl: '../resources/views/templates/apps/history/hisTrChangeStamps/hisTrChangeStampsList.html',
            controller: 'historyTrChangeStampsController'
        }).state('his-tr-payments', {
            url: '/his-tr-payments',
            templateUrl: '../resources/views/templates/apps/history/hisTrPayments/hisTrPaymentsList.html',
            controller: 'historyTrPaymentsController'
        }).state('his-tr-purchase-order-inventory', {
            url: '/his-tr-purchase-order-inventory',
            templateUrl: '../resources/views/templates/apps/history/hisTrPurchaseOrders/hisTrPurchaseOrdersList.html',
            controller: 'historyTrPurchaseOrdersController'
        }).state('his-tr-purchase-order-reward', {
            url: '/his-tr-purchase-order-reward',
            templateUrl: '../resources/views/templates/apps/history/hisTrPurchaseOrderStamps/hisTrPurchaseOrderStampsList.html',
            controller: 'historyTrPurchaseOrderStampsController'
        }).state('his-tr-stock-opname', {
            url: '/his-tr-stock-opname',
            templateUrl: '../resources/views/templates/apps/history/hisTrStockOpname/hisTrStockOpnameList.html',
            controller: 'historyTrStockOpnameController'
        }).state('database', {
            url: '/database',
            templateUrl: '../resources/views/templates/apps/database/databaseList.html',
            controller: 'databaseController'
        });
    $urlRouterProvider.otherwise('/');
});
