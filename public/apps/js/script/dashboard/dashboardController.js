var app = angular.module('dashboardCtrl', ['chart.js', 'factoryDashboard']);

app.controller('dashboardController', function($rootScope, $scope, $stateParams, $timeout, $location, $http, $state, $filter, toastr, dashboardFactory) {
    $rootScope.$state = $state;
    $scope.now_year = $filter('date')(new Date(), 'yyyy');
    $scope.loading = true;
    dashboardFactory.getCountData()
        .then(function() {
            $scope.count_student_active = dashboardFactory.resultData.data.count_student_active;
            $scope.count_student_nonactive = dashboardFactory.resultData.data.count_student_nonactive;
            $scope.deposit_student_active = dashboardFactory.resultData.data.deposit_student_active;
            $scope.deposit_student_nonactive = dashboardFactory.resultData.data.deposit_student_nonactive;
            $scope.count_reward_active = dashboardFactory.resultData.data.count_reward_active;
            $scope.count_reward_nonactive = dashboardFactory.resultData.data.count_reward_nonactive;
            $scope.price_reward_active = dashboardFactory.resultData.data.price_reward_active;
            $scope.price_reward_nonactive = dashboardFactory.resultData.data.price_reward_nonactive;
            $scope.chart_payments = dashboardFactory.resultData.data.chart_payments;
            $scope.count_voucher_active = dashboardFactory.resultData.data.count_voucher_active;
            $scope.count_voucher_nonactive = dashboardFactory.resultData.data.count_voucher_nonactive;
            $scope.value_voucher_active = dashboardFactory.resultData.data.value_voucher_active;
            $scope.value_voucher_nonactive = dashboardFactory.resultData.data.value_voucher_nonactive;
            $scope.inventory_book_qty_active = dashboardFactory.resultData.data.inventory_book_qty_active;
            $scope.inventory_book_qty_nonactive = dashboardFactory.resultData.data.inventory_book_qty_nonactive;
            $scope.inventory_book_selling_active = dashboardFactory.resultData.data.inventory_book_selling_active;
            $scope.inventory_book_selling_nonactive = dashboardFactory.resultData.data.inventory_book_selling_nonactive;
            $scope.inventory_book_buying_active = dashboardFactory.resultData.data.inventory_book_buying_active;
            $scope.inventory_book_buying_nonactive = dashboardFactory.resultData.data.inventory_book_buying_nonactive;
            $scope.inventory_accessory_qty_active = dashboardFactory.resultData.data.inventory_accessory_qty_active;
            $scope.inventory_accessory_qty_nonactive = dashboardFactory.resultData.data.inventory_accessory_qty_nonactive;
            $scope.inventory_accessory_selling_active = dashboardFactory.resultData.data.inventory_accessory_selling_active;
            $scope.inventory_accessory_selling_nonactive = dashboardFactory.resultData.data.inventory_accessory_selling_nonactive;
            $scope.inventory_accessory_buying_active = dashboardFactory.resultData.data.inventory_accessory_buying_active;
            $scope.inventory_accessory_buying_nonactive = dashboardFactory.resultData.data.inventory_accessory_buying_nonactive;
        //     $scope.data_services = dashboardFactory.resultData.data.data_services;
        //     $scope.data_customers = dashboardFactory.resultData.data.data_customers;
        //     $scope.data_items = dashboardFactory.resultData.data.data_items;
        //     $scope.data_chart_services = dashboardFactory.resultData.data.cart_services;
        //     $scope.data_chart_sales = dashboardFactory.resultData.data.cart_sales;
            var tr_payments_month = [];
            var tr_payments_total = [];
            for (var i = 0; i < $scope.chart_payments.length; i++) {
                var month = $scope.chart_payments[i]['month'];
                switch (month) {
                    case 1:
                        month = "Jan";
                        break;
                    case 2:
                        month = "Feb";
                        break;
                    case 3:
                        month = "Mar";
                        break;
                    case 4:
                        month = "Apr";
                        break;
                    case 5:
                        month = "May";
                        break;
                    case 6:
                        month = "Jun";
                        break;
                    case 7:
                        month = "Jul";
                        break;
                    case 8:
                        month = "Aug";
                        break;
                    case 9:
                        month = "Sep";
                        break;
                    case 10:
                        month = "Oct";
                        break;
                    case 11:
                        month = "Nov";
                        break;
                    case 12:
                        month = "Dec";
                        break;
                    default:

                }
                tr_payments_month[i] = month;
                tr_payments_total[i] = $scope.chart_payments[i]['grand_total'];
            }
            console.log(tr_payments_total);
            $scope.tr_payments_data = [
                tr_payments_total
            ];
            $scope.tr_payments_labels = tr_payments_month;
            $scope.tr_payments_series = ['Income Total'];
            $scope.options = {
                tooltips: {
                    mode: 'label',
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel.toString().split(/(?=(?:...)*$)/).join('.');
                        }
                    }
                },
                scales: {
                    yAxes: [
                        {
                            id: 'y-axis-1',
                            type: 'linear',
                            display: true,
                            position: 'left',
                            ticks: {
                                userCallback: function(value, index, values) {
                                    // Convert the number to a string and splite the string every 3 charaters from the end
                                    value = value.toString();
                                    value = value.split(/(?=(?:...)*$)/);

                                    // Convert the array to a string and format the output
                                    value = value.join('.');
                                    return '' + value;
                                }
                            },
                        }
                    ]
                }
            };
            $scope.loading = false;
        });

    // Simulate async data update
    // $timeout(function () {
    //     $scope.data = [
    //         [50, 70, 80, 91, 56, 55, 50, 85, 59, 80, 81, 80]
    //     ];
    // }, 3000);
})
