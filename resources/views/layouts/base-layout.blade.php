<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>CMA Apps</title>
	<!-- Angular Material style sheet -->
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/mdi/css/materialdesignicons.min.css') }}">
	{{-- <link rel="stylesheet" href="{{ asset('public/plugin/bower_components/angular-toastr/dist/toastr.min.css') }}" /> --}}
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/angular-toastr/dist/angular-toastr.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/angular-loading-bar/build/loading-bar.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/angular-ui-select/dist/select.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/selectize/dist/css/selectize.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/angular-colorpicker-directive/css/color-picker.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/angular-tabs/angular-tabs.css') }}" />
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/jquery-ui/themes/base/jquery-ui.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/angular-hotkeys/build/hotkeys.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('public/plugin/bower_components/stickyTable/stickyTable.css') }}"/>
	<link rel="stylesheet" href="{{ asset('public/apps/css/vs-style.css') }}">
	<link rel="shortcut icon" href="{{ asset('public/apps/img/favicon.png') }}">
	{{-- <base href="{{ asset('/') }}"> --}}
</head>
<body ng-app="desktopApps" ng-cloak ng-controller="pluginController" zurbinit>
	<div style="width: 100%; height: 100%; background: #3c4ca2; position: absolute; z-index: 9999;" id="loading">
		<div class="middle-center" style="width: 100%; height: 100%">
			<div>
				<div class="spinner">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			</div>
		</div>
	</div>
	<header data-sticky-container>
		<div class="sticky vs-header z-depth-low" data-sticky data-margin-top="0" data-sticky-on="small">
			<div class="grid-x grid-padding-x">
				<div class="large-2 cell padding-0">
					<div class="vs-logo z-depth-low">
						<a @if (Auth::user()->permission == 99 || Auth::user()->permission == 1) ui-sref="dashboard" @else href="javascript:;" @endif class="middle-center">
							<img src="{{ asset('public/apps/img/logo/logo-white.png') }}" alt="" width="56">
						</a>
						<input type="hidden" id="user_id" value="{{ Auth::user()->permission }}">
						<input type="hidden" id="user_app" value="{{ Auth::user()->id }}">
					</div>
				</div>
				<div class="large-8 cell middle-left">
					<ul class="menu vs-menu dropdown" data-dropdown-menu>
						<li class="is-dropdown-submenu-parent">
							<a href="" class="middle-left">
								<img src="{{ asset('public/apps/img/icon/folder.png') }}" class="mdi-right">
								<span class="font-medium">Master Data</span>
							</a>
							<ul class="menu vertical z-depth-1 vs-submenu vs-bg-smoke">
								<li><a ui-sref="category-list" ui-sref-opts="{reload: true}">Categories</a></li>
								<li><a ui-sref="item-list" ui-sref-opts="{reload: true}">Inventory</a></li>
								<li><a ui-sref="student-list" ui-sref-opts="{reload: true}">Students</a></li>
								<li><a ui-sref="tuition-list" ui-sref-opts="{reload: true}">Tuition</a></li>
								<li><a ui-sref="stamp-list" ui-sref-opts="{reload: true}">Rewards</a></li>
								<li><a ui-sref="user-list" ui-sref-opts="{reload: true}">Users</a></li>
								<li><a ui-sref="voucher-list" ui-sref-opts="{reload: true}">Vouchers</a></li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="middle-left">
								<img src="{{ asset('public/apps/img/icon/cashier.png') }}" class="mdi-right">
								<span class="font-medium">Transaction</span>
							</a>
							<ul class="menu vertical z-depth-1 vs-submenu vs-bg-smoke">
								<li><a ui-sref="tr-payment-create" ui-sref-opts="{reload: true}">Payments</a></li>
								<li><a ui-sref="tr-changebook-create" ui-sref-opts="{reload: true}">Change Books</a></li>
								<li><a ui-sref="tr-changestamp-create" ui-sref-opts="{reload: true}">Change Stamps</a></li>
							</ul>
						</li>
						<li class="is-dropdown-submenu-parent">
							<a href="javascript:;" class="middle-left">
								<img src="{{ asset('public/apps/img/icon/books.png') }}" class="mdi-right">
								<span class="font-medium">PO & Stock Opname</span>
							</a>
							<ul class="menu vertical z-depth-1 vs-submenu vs-bg-smoke">
								<li><a ui-sref="tr-purchase-order-create" ui-sref-opts="{reload: true}">Purchase Order Inventory</a></li>
								<li><a ui-sref="tr-purchase-order-stamp-create" ui-sref-opts="{reload: true}">Purchase Order Reward</a></li>
								<li><a ui-sref="tr-stock-opname" ui-sref-opts="{reload: true}">Stock Opname</a></li>
							</ul>
						</li>
						<li class="is-dropdown-submenu-parent">
							<a href="" class="middle-left">
								<img src="{{ asset('public/apps/img/icon/graph.png') }}" class="mdi-right">
								<span class="font-medium">Report</span>
							</a>
							<ul class="menu vertical z-depth-1 vs-submenu vs-bg-smoke" style="min-width: 280px;">
								<li><a ui-sref="rep-tr-payments" ui-sref-opts="{reload: true}">1. Rep. Payments</a></li>
								<li><a ui-sref="rep-tr-change-books" ui-sref-opts="{reload: true}">2. Rep. Deposit Top Up & Change Book</a></li>
								<li><a ui-sref="rep-tr-change-stamps" ui-sref-opts="{reload: true}">3. Rep. Change Stamp</a></li>
								<li><a ui-sref="rep-items" ui-sref-opts="{reload: true}">4. Rep. Stock Inventory</a></li>
								<li><a ui-sref="rep-deposit-books" ui-sref-opts="{reload: true}">5. Rep. Balance Deposit Book</a></li>
								<li><a ui-sref="rep-stock-gift-rewards" ui-sref-opts="{reload: true}">6. Rep. Stock Reward</a></li>
								<li><a ui-sref="rep-student-last-books" ui-sref-opts="{reload: true}">7. Rep. Student Book Record</a></li>
								{{-- <li><a ui-sref="rep-tr-payment-students" ui-sref-opts="{reload: true}">7. Rep. Payment per Students</a></li> --}}
								{{-- <li><a ui-sref="rep-student-change-books" ui-sref-opts="{reload: true}">8. Rep. Student Change Book</a></li> --}}
								<li><a ui-sref="rep-new-students" ui-sref-opts="{reload: true}">8. Rep. New Student</a></li>
								<li><a ui-sref="rep-purchase-orders" ui-sref-opts="{reload: true}">9. Rep. Purchase Order Inventory</a></li>
								<li><a ui-sref="rep-purchase-order-rewards" ui-sref-opts="{reload: true}">10. Rep. Purchase Order Reward</a></li>
								<li><a ui-sref="rep-stock-opname" ui-sref-opts="{reload: true}">11. Rep. Stock Opname Inventory</a></li>
								<li><a ui-sref="rep-stock-opname-reward" ui-sref-opts="{reload: true}">12. Rep. Stock Opname Reward</a></li>
								<li><a ui-sref="rep-balance-sheet" ui-sref-opts="{reload: true}">13. Rep. Balance Sheet</a></li>
								<li><a ui-sref="rep-income-statement" ui-sref-opts="{reload: true}">14. Rep. Income Statement</a></li>
								{{-- <li><a href="#" ui-sref-opts="{reload: true}">Lap. Pengguna</a></li> --}}
							</ul>
						</li>
						<li class="is-dropdown-submenu-parent">
							<a href="" class="middle-left">
								<img src="{{ asset('public/apps/img/icon/log.png') }}" class="mdi-right">
								<span class="font-medium">History</span>
							</a>
							<ul class="menu vertical z-depth-1 vs-submenu vs-bg-smoke">
								<li><a ui-sref="his-tr-payments">History Payments</a></li>
								<li><a ui-sref="his-tr-change-books">History Change Books</a></li>
								<li><a ui-sref="his-tr-change-stamps">History Change Stamps</a></li>
								<li><a ui-sref="his-tr-purchase-order-inventory">History PO Inventory</a></li>
								<li><a ui-sref="his-tr-purchase-order-reward">History PO Reward</a></li>
								<li><a ui-sref="his-tr-stock-opname">History Stock Opname</a></li>
								<li><a ui-sref="his-login">History Login</a></li>
							</ul>
						</li>
						<li>
							<a ui-sref="database" class="middle-left">
								<img src="{{ asset('public/apps/img/icon/database.png') }}" class="mdi-right">
								<span class="font-medium">Database</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="large-2 cell float-right padding-0">
					<ul class="menu vs-account align-right dropdown margin-top-0" data-dropdown-menu>
						<li ng-show="min_stock.length > 0">
							<a href="" class="middle-left" style="padding: 8px 10px;">
								<i class="mdi mdi-bell-ring mdi-36px" style="color: #e4c05c"></i>
							</a>
							<ul class="menu vertical z-depth-1 vs-submenu vs-bg-smoke submenu-account" style="width: 325px; height: 600px; overflow: auto" ng-show="min_stock.length > 0">
								<li ng-include="'../resources/views/templates/base/nav.html'"></li>
							</ul>
						</li>
						<li>
							<a href="" class="middle-left" style="padding: 0px 16px;">
								<div class="middle-left" style="padding: 4px 16px 4px 6px; border-radius: 24px; background: #d4dff7">
									<img src="{{ asset('public/apps/img/icon/women.png') }}" class="mdi-right">
									<span class="font-bold account-title">{{ Auth::user()->name }}</span>
								</div>
							</a>
							<ul class="menu vertical z-depth-1 vs-submenu vs-bg-smoke submenu-account">
								{{-- <li style="border-bottom: 1px solid #ddd">
								<a href="javascript:;" class="middle-left"><i class="mdi mdi-account-circle mdi-right mdi-18px"></i> {{ Auth::user()->first_name }}</a>
							</li> --}}
							<li>
								<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="middle-left" style="width: 100%" id="logout"><i class="mdi mdi-logout mdi-right mdi-18px"></i> Keluar</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>
<section class="vs-content" fullbody>
	<div class="vs-page">
		<div class="vs-loader"></div>
		<ui-view></ui-view>
	</div>
</section>
<script src="{{ asset('public/plugin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/jquery.preload-master/jquery.preload.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/what-input/dist/what-input.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/foundation-sites/dist/js/foundation.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/stickyTable/stickyTable.min.js') }}"></script>
{{-- Start Angular Libraries --}}
<script src="{{ asset('public/plugin/bower_components/angular/angular.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/ui-autocomplete/autocomplete.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-ui-date/dist/date.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-sanitize/angular-sanitize.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-route/angular-route.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-ui-router/release/angular-ui-router.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-animate/angular-animate.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-aria/angular-aria.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-messages/angular-messages.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-sticky/dist/angular-sticky.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-toggle/angular-toggle.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-tabs/angular-tabs.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-filter/dist/angular-filter.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-ui-tinymce/src/tinymce.js') }}"></script>
{{-- <script src="{{ asset('public/plugin/bower_components/angular-toastr/dist/toastr.min.js') }}"></script> --}}
<script src="{{ asset('public/plugin/bower_components/angular-toastr/dist/angular-toastr.tpls.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-loading-bar/build/loading-bar.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-ui-select/dist/select.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-i18n/angular-i18n.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-file-upload/dist/angular-file-upload.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-input-masks/angular-input-masks-standalone.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-hotkeys/build/hotkeys.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-barcode-scan/angular.scannerdetection.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/birthday-picker/bday-picker.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/chart.js/dist/chart.min.js') }}"></script>
<script src="{{ asset('public/plugin/bower_components/angular-chart.js/dist/angular-chart.min.js') }}"></script>
{{-- End Angular Libraries --}}
{{-- Start Directive --}}
<script src="{{ asset('public/plugin/bower_components/angularUtils-pagination/dirPagination.js') }}"></script>
<script src="{{ asset('public/apps/js/script/base/pluginDirective.js') }}"></script>
{{-- End Directive --}}

{{-- Start Master Controller --}}
<script src="{{ asset('public/apps/js/script/base/_pluginController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/dashboard/dashboardController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/categories/categoryController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/students/studentController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/items/itemController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/tuitions/tuitionController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/stamps/stampController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/users/userController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/vouchers/voucherController.js') }}"></script>
{{-- End Master Controller --}}

{{-- Start Transaction Controller --}}
<script src="{{ asset('public/apps/js/script/transaction/trPurchaseOrders/trPurchaseOrdersController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/transaction/trPurchaseOrderStamps/trPurchaseOrderStampsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/transaction/trPayments/trPaymentsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/transaction/trChangeBooks/trChangeBooksController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/transaction/trChangeStamps/trChangeStampsController.js') }}"></script>
{{-- End Transaction Controller --}}

{{-- Start Inventory Factory --}}
<script src="{{ asset('public/apps/js/script/inventory/trStockOpname/trStockOpnameController.js') }}"></script>
{{-- End Transaction Factory --}}

{{-- Start History Controller --}}
<script src="{{ asset('public/apps/js/script/history/historyLogin/historyLoginController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrChangeBooks/historyTrChangeBooksController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrChangeStamps/historyTrChangeStampsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrPayments/historyTrPaymentsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrPurchaseOrders/historyTrPurchaseOrdersController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrPurchaseOrderStamps/historyTrPurchaseOrderStampsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrStockOpname/historyTrStockOpnameController.js') }}"></script>
{{-- End History Controller --}}

{{-- Start Report Controller --}}
<script src="{{ asset('public/apps/js/script/report/reportTrPayments/reportTrPaymentsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportTrChangeBooks/reportTrChangeBooksController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportTrChangeStamps/reportTrChangeStampsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportItems/reportItemsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportDepositBooks/reportDepositBooksController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportStockGiftRewards/reportStockGiftRewardsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportStudentLastBooks/reportStudentLastBooksController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportTrPaymentStudents/reportTrPaymentStudentsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportNewStudents/reportNewStudentsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportPurchaseOrders/reportPurchaseOrdersController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportPurchaseOrderRewards/reportPurchaseOrderRewardsController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportStockOpname/reportStockOpnameController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportStockOpnameReward/reportStockOpnameRewardController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportBalanceSheet/reportBalanceSheetController.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportIncomeStatement/reportIncomeStatementController.js') }}"></script>
{{-- End Report Controller --}}
<script src="{{ asset('public/apps/js/script/database/databaseController.js') }}"></script>

{{-- Start Dashboard Factory --}}
<script src="{{ asset('public/apps/js/script/dashboard/dashboardFactory.js') }}"></script>
{{-- End Dashboard Factory --}}
{{-- Start Master Factory --}}
<script src="{{ asset('public/apps/js/script/master/categories/categoryFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/students/studentFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/items/itemFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/tuitions/tuitionFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/stamps/stampFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/users/userFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/master/vouchers/voucherFactory.js') }}"></script>
{{-- End Master Factory --}}

{{-- Start Transaction Factory --}}
<script src="{{ asset('public/apps/js/script/transaction/trPurchaseOrders/trPurchaseOrdersFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/transaction/trPurchaseOrderStamps/trPurchaseOrderStampsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/transaction/trPayments/trPaymentsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/transaction/trChangeBooks/trChangeBooksFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/transaction/trChangeStamps/trChangeStampsFactory.js') }}"></script>
{{-- End Transaction Factory --}}

{{-- Start Inventory Factory --}}
<script src="{{ asset('public/apps/js/script/inventory/trStockOpname/trStockOpnameFactory.js') }}"></script>
{{-- End Transaction Factory --}}

{{-- Start History Factory --}}
<script src="{{ asset('public/apps/js/script/history/historyLogin/historyLoginFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrChangeBooks/historyTrChangeBooksFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrChangeStamps/historyTrChangeStampsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrPayments/historyTrPaymentsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrPurchaseOrders/historyTrPurchaseOrdersFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrPurchaseOrderStamps/historyTrPurchaseOrderStampsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/history/historyTrStockOpname/historyTrStockOpnameFactory.js') }}"></script>
{{-- End History Factory --}}

{{-- Start Report Factory --}}
<script src="{{ asset('public/apps/js/script/report/reportTrPayments/reportTrPaymentsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportTrChangeBooks/reportTrChangeBooksFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportTrChangeStamps/reportTrChangeStampsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportItems/reportItemsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportDepositBooks/reportDepositBooksFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportStockGiftRewards/reportStockGiftRewardsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportStudentLastBooks/reportStudentLastBooksFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportTrPaymentStudents/reportTrPaymentStudentsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportNewStudents/reportNewStudentsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportPurchaseOrders/reportPurchaseOrdersFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportPurchaseOrderRewards/reportPurchaseOrderRewardsFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportStockOpname/reportStockOpnameFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportStockOpnameReward/reportStockOpnameRewardFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportBalanceSheet/reportBalanceSheetFactory.js') }}"></script>
<script src="{{ asset('public/apps/js/script/report/reportIncomeStatement/reportIncomeStatementFactory.js') }}"></script>
{{-- End Report Factory --}}
<script src="{{ asset('public/apps/js/script/database/databaseFactory.js') }}"></script>

{{-- Start Global --}}
<script src="{{ asset('public/apps/js/script/global.js') }}"></script>
<script src="{{ asset('public/apps/js/script/app.js') }}"></script>
<script type="text/javascript">
$.preload([
	"{{ asset('public/apps/css/vs-style.css') }}",
	"{{ asset('public/plugin/bower_components/foundation-sites/dist/js/foundation.min.js') }}"
]).then(function() {
	$("#loading").css("display", "none");
}, function() {
	console.error("Something went wrong.")
}, function(progress) {
	$("#loading").css("display", "block");
	console.debug(Math.round(progress * 100) + '%')
})

window.setInterval(function()
{
	$.ajax({
        url : 'user/checkAuth',
        type : 'GET',
        dataType : 'JSON',
        success : function(resp){
            if (resp == false) {
				console.log(resp);
            	location.reload();
            } else {
				console.log(resp);
			}
        },
    });
}, 3605000);
</script>
{{-- End Global --}}
</body>
</html>
