<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'Apps\Dashboard\DashboardCtrl@index')->name('dashboard.index')->middleware('auth');
// Route::get('/', 'Apps\Transaction\TrPaymentsCtrl@index')->name('trPayments.index')->middleware('auth');
Route::get('/dashboard/getCountData', 'Apps\Dashboard\DashboardCtrl@getCountData')->name('dashboard.getCountData')->middleware('auth');
// CATEGORY ROUTE
Route::get('/category', 'Apps\Master\CategoryCtrl@index')->name('category.index');
Route::get('/category/list', 'Apps\Master\CategoryCtrl@index')->name('category.index');
Route::post('/category/insert', 'Apps\Master\CategoryCtrl@insert')->name('category.insert');
Route::get('/category/edit/{id}', 'Apps\Master\CategoryCtrl@edit')->name('category.edit');
Route::post('/category/update/{id}', 'Apps\Master\CategoryCtrl@update')->name('category.update');
Route::post('/category/delete/{id}', 'Apps\Master\CategoryCtrl@delete')->name('category.delete');
Route::get('/category/all', 'Apps\Master\CategoryCtrl@getAll')->name('category.getAll');

// USER ROUTE
Route::get('/user', 'Apps\Master\UserCtrl@index')->name('user.index');
Route::get('/user/list', 'Apps\Master\UserCtrl@index')->name('user.index');
Route::post('/user/insert', 'Apps\Master\UserCtrl@insert')->name('user.insert');
Route::get('/user/edit/{id}', 'Apps\Master\UserCtrl@edit')->name('user.edit');
Route::post('/user/update/{id}', 'Apps\Master\UserCtrl@update')->name('user.update');
Route::post('/user/delete/{id}', 'Apps\Master\UserCtrl@delete')->name('user.delete');
Route::get('/user/detail/{id}', 'Apps\Master\UserCtrl@getUserDetail')->name('user.getUserDetail');
Route::get('/user/all', 'Apps\Master\UserCtrl@getAll')->name('user.getAll');
Route::get('/user/checkAuth', 'Apps\Master\UserCtrl@checkAuth')->name('user.checkAuth');

// SUPPLIER ROUTE
Route::get('/student', 'Apps\Master\StudentCtrl@index')->name('student.index');
Route::get('/student/list', 'Apps\Master\StudentCtrl@index')->name('student.index');
Route::post('/student/insert', 'Apps\Master\StudentCtrl@insert')->name('student.insert');
Route::get('/student/edit/{id}', 'Apps\Master\StudentCtrl@edit')->name('student.edit');
Route::get('/student/detail/{id}', 'Apps\Master\StudentCtrl@getStudentDetail')->name('student.getStudentDetail');
Route::post('/student/update/{id}', 'Apps\Master\StudentCtrl@update')->name('student.update');
Route::post('/student/delete/{id}', 'Apps\Master\StudentCtrl@delete')->name('student.delete');
Route::get('/student/manual', 'Apps\Master\StudentCtrl@searchStudent')->name('student.searchStudent');
Route::get('/student/all', 'Apps\Master\StudentCtrl@getAll')->name('student.getAll');

// ITEM ROUTE
Route::get('/item', 'Apps\Master\ItemCtrl@index')->name('item.index');
Route::get('/item/list', 'Apps\Master\ItemCtrl@index')->name('item.index');
Route::post('/item/insert', 'Apps\Master\ItemCtrl@insert')->name('item.insert');
Route::get('/item/edit/{id}', 'Apps\Master\ItemCtrl@edit')->name('item.edit');
Route::post('/item/update/{id}', 'Apps\Master\ItemCtrl@update')->name('item.update');
Route::post('/item/delete/{id}', 'Apps\Master\ItemCtrl@delete')->name('item.delete');
Route::get('/item/min-stock', 'Apps\Master\ItemCtrl@minStock')->name('item.minStock');
Route::get('/item/detail/{id}', 'Apps\Master\ItemCtrl@getItemDetail')->name('item.getItemDetail');
Route::get('/item/manual', 'Apps\Master\ItemCtrl@searchItem')->name('item.searchItem');
Route::get('/item/all', 'Apps\Master\ItemCtrl@searchItemAll')->name('item.searchItemAll');
Route::get('/item/getStarterKids/{id}', 'Apps\Master\ItemCtrl@getStarterKids')->name('item.getStarterKids');
Route::get('/item/book', 'Apps\Master\ItemCtrl@searchBook')->name('item.searchBook');

// TUITION ROUTE
Route::get('/tuition', 'Apps\Master\TuitionCtrl@index')->name('tuition.index');
Route::get('/tuition/list', 'Apps\Master\TuitionCtrl@index')->name('tuition.index');
Route::post('/tuition/insert', 'Apps\Master\TuitionCtrl@insert')->name('tuition.insert');
Route::get('/tuition/edit/{id}', 'Apps\Master\TuitionCtrl@edit')->name('tuition.edit');
Route::post('/tuition/update/{id}', 'Apps\Master\TuitionCtrl@update')->name('tuition.update');
Route::post('/tuition/delete/{id}', 'Apps\Master\TuitionCtrl@delete')->name('tuition.delete');
Route::get('/tuition/manual', 'Apps\Master\TuitionCtrl@searchTuition')->name('tuition.searchTuition');

// STAMP ROUTE
Route::get('/stamp', 'Apps\Master\StampCtrl@index')->name('stamp.index');
Route::get('/stamp/list', 'Apps\Master\StampCtrl@index')->name('stamp.index');
Route::post('/stamp/insert', 'Apps\Master\StampCtrl@insert')->name('stamp.insert');
Route::get('/stamp/edit/{id}', 'Apps\Master\StampCtrl@edit')->name('stamp.edit');
Route::post('/stamp/update/{id}', 'Apps\Master\StampCtrl@update')->name('stamp.update');
Route::post('/stamp/delete/{id}', 'Apps\Master\StampCtrl@delete')->name('stamp.delete');
Route::get('/stamp/search', 'Apps\Master\StampCtrl@searchStamp')->name('stamp.searchStamp');

// VOUCHER ROUTE
Route::get('/voucher', 'Apps\Master\VoucherCtrl@index')->name('voucher.index');
Route::get('/voucher/list', 'Apps\Master\VoucherCtrl@index')->name('voucher.index');
Route::post('/voucher/insert', 'Apps\Master\VoucherCtrl@insert')->name('voucher.insert');
Route::get('/voucher/edit/{id}', 'Apps\Master\VoucherCtrl@edit')->name('voucher.edit');
Route::post('/voucher/update/{id}', 'Apps\Master\VoucherCtrl@update')->name('voucher.update');
Route::post('/voucher/delete/{id}', 'Apps\Master\VoucherCtrl@delete')->name('voucher.delete');
Route::get('/voucher/all', 'Apps\Master\VoucherCtrl@getAll')->name('voucher.getAll');

// TRANSACTION PAYMENTS ROUTE
Route::get('/trPayments/list', 'Apps\Transaction\TrPaymentsCtrl@data')->name('trPayments.data');
Route::post('/trPayments/insert', 'Apps\Transaction\TrPaymentsCtrl@insert')->name('trPayments.insert');
Route::post('/trPayments/cartAdd', 'Apps\Transaction\TrPaymentsCtrl@cartAdd')->name('trPayments.cartAdd');
Route::post('/trPayments/cartRemove', 'Apps\Transaction\TrPaymentsCtrl@cartRemove')->name('trPayments.cartRemove');
Route::get('/trPayments/cartDestroy', 'Apps\Transaction\TrPaymentsCtrl@cartDestroy')->name('trPayments.cartDestroy');
Route::get('/trPayments/searchTuitionManual/{id}', 'Apps\Transaction\TrPaymentsCtrl@searchTuitionManual')->name('trPayments.searchTuitionManual');
Route::get('/trPayments/searchItemManual/{id}', 'Apps\Transaction\TrPaymentsCtrl@searchItemManual')->name('trPayments.searchItemManual');

// TRANSACTION CHANGE BOOKS ROUTE
Route::get('/trChangeBooks/list', 'Apps\Transaction\TrChangeBooksCtrl@data')->name('trChangeBooks.data');
Route::post('/trChangeBooks/insert', 'Apps\Transaction\TrChangeBooksCtrl@insert')->name('trChangeBooks.insert');
Route::post('/trChangeBooks/cartAdd', 'Apps\Transaction\TrChangeBooksCtrl@cartAdd')->name('trChangeBooks.cartAdd');
Route::post('/trChangeBooks/cartRemove', 'Apps\Transaction\TrChangeBooksCtrl@cartRemove')->name('trChangeBooks.cartRemove');
Route::get('/trChangeBooks/cartDestroy', 'Apps\Transaction\TrChangeBooksCtrl@cartDestroy')->name('trChangeBooks.cartDestroy');
Route::get('/trChangeBooks/searchTuitionManual/{id}', 'Apps\Transaction\TrChangeBooksCtrl@searchTuitionManual')->name('trChangeBooks.searchTuitionManual');
Route::get('/trChangeBooks/searchItemManual/{id}', 'Apps\Transaction\TrChangeBooksCtrl@searchItemManual')->name('trChangeBooks.searchItemManual');
Route::get('/trChangeBooks/filter', 'Apps\Transaction\TrChangeBooksCtrl@filterTrChangeBooks')->name('trChangeBooks.filterTrChangeBooks');
Route::get('/trChangeBooks/delete/{id}', 'Apps\Transaction\TrChangeBooksCtrl@deleteTrChangeBooks')->name('trChangeBooks.deleteTrChangeBooks');

// TRANSACTION CHANGE STAMPS ROUTE
Route::get('/trChangeStamps/list', 'Apps\Transaction\TrChangeStampsCtrl@data')->name('trChangeStamps.data');
Route::post('/trChangeStamps/insert', 'Apps\Transaction\TrChangeStampsCtrl@insert')->name('trChangeStamps.insert');
Route::post('/trChangeStamps/cartAdd', 'Apps\Transaction\TrChangeStampsCtrl@cartAdd')->name('trChangeStamps.cartAdd');
Route::post('/trChangeStamps/cartRemove', 'Apps\Transaction\TrChangeStampsCtrl@cartRemove')->name('trChangeStamps.cartRemove');
Route::get('/trChangeStamps/cartDestroy', 'Apps\Transaction\TrChangeStampsCtrl@cartDestroy')->name('trChangeStamps.cartDestroy');
Route::get('/trChangeStamps/searchStamp/{id}', 'Apps\Transaction\TrChangeStampsCtrl@searchStamp')->name('trChangeStamps.searchStamp');

// TRANSACTION PURCHASE ORDER ROUTE
Route::get('/trPurchaseOrders/getCart', 'Apps\Transaction\TrPurchaseOrdersCtrl@getDataCart')->name('trPurchaseOrders.getDataCart');
Route::post('/trPurchaseOrders/cartAdd', 'Apps\Transaction\TrPurchaseOrdersCtrl@cartAdd')->name('trPurchaseOrders.cartAdd');
Route::get('/trPurchaseOrders/cartRemove/{id}', 'Apps\Transaction\TrPurchaseOrdersCtrl@cartRemove')->name('trPurchaseOrders.cartRemove');
Route::get('/trPurchaseOrders/cartEditRemove/{id}', 'Apps\Transaction\TrPurchaseOrdersCtrl@cartEditRemove')->name('trPurchaseOrders.cartEditRemove');
Route::get('/trPurchaseOrders/cartDestroy', 'Apps\Transaction\TrPurchaseOrdersCtrl@cartDestroy')->name('trPurchaseOrders.cartDestroy');
Route::post('/trPurchaseOrders/insert', 'Apps\Transaction\TrPurchaseOrdersCtrl@insert')->name('trPurchaseOrders.insert');
Route::get('/trPurchaseOrders/edit/{id}', 'Apps\Transaction\TrPurchaseOrdersCtrl@edit')->name('trPurchaseOrders.edit');
Route::post('/trPurchaseOrders/update/{id}', 'Apps\Transaction\TrPurchaseOrdersCtrl@update')->name('trPurchaseOrders.update');
Route::post('/trPurchaseOrders/delete/{id}', 'Apps\Transaction\TrPurchaseOrdersCtrl@delete')->name('trPurchaseOrders.delete');
Route::get('/trPurchaseOrders/searchItemManual/{id}', 'Apps\Transaction\TrPurchaseOrdersCtrl@searchItemManual')->name('trPurchaseOrders.searchItemManual');

// TRANSACTION PURCHASE ORDER STAMP ROUTE
Route::get('/trPurchaseOrderStamps/getCart', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@getDataCart')->name('trPurchaseOrderStamps.getDataCart');
Route::post('/trPurchaseOrderStamps/cartAdd', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@cartAdd')->name('trPurchaseOrderStamps.cartAdd');
Route::get('/trPurchaseOrderStamps/cartRemove/{id}', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@cartRemove')->name('trPurchaseOrderStamps.cartRemove');
Route::get('/trPurchaseOrderStamps/cartEditRemove/{id}', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@cartEditRemove')->name('trPurchaseOrderStamps.cartEditRemove');
Route::get('/trPurchaseOrderStamps/cartDestroy', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@cartDestroy')->name('trPurchaseOrderStamps.cartDestroy');
Route::post('/trPurchaseOrderStamps/insert', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@insert')->name('trPurchaseOrderStamps.insert');
Route::get('/trPurchaseOrderStamps/edit/{id}', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@edit')->name('trPurchaseOrderStamps.edit');
Route::post('/trPurchaseOrderStamps/update/{id}', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@update')->name('trPurchaseOrderStamps.update');
Route::post('/trPurchaseOrderStamps/delete/{id}', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@delete')->name('trPurchaseOrderStamps.delete');
Route::get('/trPurchaseOrderStamps/searchStampManual/{id}', 'Apps\Transaction\TrPurchaseOrderStampsCtrl@searchStampManual')->name('trPurchaseOrderStamps.searchStampManual');

// INVENTORY ROUTE
Route::get('/trStockOpname/list', 'Apps\Inventory\TrStockOpnameCtrl@index')->name('trStockOpname.index');
Route::post('/trStockOpname/insert', 'Apps\Inventory\TrStockOpnameCtrl@insert')->name('trStockOpname.insert');
Route::post('/trStockOpname/done', 'Apps\Inventory\TrStockOpnameCtrl@done')->name('trStockOpname.done');
Route::post('/trStockOpname/edit', 'Apps\Inventory\TrStockOpnameCtrl@edit')->name('trStockOpname.edit');
Route::post('/trStockOpname/delete', 'Apps\Inventory\TrStockOpnameCtrl@delete')->name('trStockOpname.delete');
Route::get('/trStockOpname/getItem/{id}', 'Apps\Inventory\TrStockOpnameCtrl@getItem')->name('trStockOpname.getItem');

// REPORT ROUTE
Route::get('/reportTrPayments/filter', 'Apps\Report\ReportTrPaymentsCtrl@filterReportTrPayments')->name('reportTrPayments.filterReportTrPayments');
Route::get('/reportTrPayments/detail/{id}', 'Apps\Report\ReportTrPaymentsCtrl@getReportTrPaymentsDetail')->name('reportTrPayments.getReportTrPaymentsDetail');
Route::get('/reportTrPayments/exportExcel', 'Apps\Report\ReportTrPaymentsCtrl@exportExcel')->name('reportTrPayments.exportExcel');
Route::get('/reportTrPayments/delete/{id}', 'Apps\Report\ReportTrPaymentsCtrl@deleteTrPayments')->name('reportTrPayments.deleteTrPayments');

Route::get('/reportTrChangeBooks/filter', 'Apps\Report\ReportTrChangeBooksCtrl@filterReportTrChangeBooks')->name('reportTrChangeBooks.filterReportTrChangeBooks');
Route::get('/reportTrChangeBooks/detail/{id}', 'Apps\Report\ReportTrChangeBooksCtrl@getReportTrChangeBooksDetail')->name('reportTrChangeBooks.getReportTrChangeBooksDetail');
Route::get('/reportTrChangeBooks/exportExcel', 'Apps\Report\ReportTrChangeBooksCtrl@exportExcel')->name('reportTrChangeBooks.exportExcel');

Route::get('/reportTrChangeStamps/filter', 'Apps\Report\ReportTrChangeStampsCtrl@filterReportTrChangeStamps')->name('reportTrChangeStamps.filterReportTrChangeStamps');
Route::get('/reportTrChangeStamps/detail/{id}', 'Apps\Report\ReportTrChangeStampsCtrl@getReportTrChangeStampsDetail')->name('reportTrChangeStamps.getReportTrChangeStampsDetail');
Route::get('/reportTrChangeStamps/exportExcel', 'Apps\Report\ReportTrChangeStampsCtrl@exportExcel')->name('reportTrChangeStamps.exportExcel');

Route::get('/reportItems/filter', 'Apps\Report\ReportItemsCtrl@filterReportItems')->name('reportItems.filterReportItems');
Route::get('/reportItems/exportExcel', 'Apps\Report\ReportItemsCtrl@exportExcel')->name('reportItems.exportExcel');

Route::get('/reportDepositBooks/filter', 'Apps\Report\ReportDepositBooksCtrl@filterReportDepositBooks')->name('reportDepositBooks.filterReportDepositBooks');
Route::get('/reportDepositBooks/exportExcel', 'Apps\Report\ReportDepositBooksCtrl@exportExcel')->name('reportDepositBooks.exportExcel');

Route::get('/reportStockGiftRewards/filter', 'Apps\Report\ReportStockGiftRewardsCtrl@filterReportStockGiftRewards')->name('reportStockGiftRewards.filterReportStockGiftRewards');
Route::get('/reportStockGiftRewards/exportExcel', 'Apps\Report\ReportStockGiftRewardsCtrl@exportExcel')->name('reportStockGiftRewards.exportExcel');

Route::get('/reportStudentLastBooks/filter', 'Apps\Report\ReportStudentLastBooksCtrl@filterReportStudentLastBooks')->name('reportStudentLastBooks.filterReportStudentLastBooks');
Route::get('/reportStudentLastBooks/exportExcel', 'Apps\Report\ReportStudentLastBooksCtrl@exportExcel')->name('reportStudentLastBooks.exportExcel');

Route::get('/reportTrPaymentStudents/filter', 'Apps\Report\ReportTrPaymentStudentsCtrl@filterReportTrPaymentStudents')->name('reportTrPaymentStudents.filterReportTrPaymentStudents');
Route::get('/reportTrPaymentStudents/detail/{id}', 'Apps\Report\ReportTrPaymentStudentsCtrl@getReportTrPaymentStudentsDetail')->name('reportTrPaymentStudents.getReportTrPaymentStudentsDetail');
Route::get('/reportTrPaymentStudents/exportExcel', 'Apps\Report\ReportTrPaymentStudentsCtrl@exportExcel')->name('reportTrPaymentStudents.exportExcel');

Route::get('/reportNewStudents/filter', 'Apps\Report\ReportNewStudentsCtrl@filterReportNewStudents')->name('reportNewStudents.filterReportNewStudents');
Route::get('/reportNewStudents/exportExcel', 'Apps\Report\ReportNewStudentsCtrl@exportExcel')->name('reportNewStudents.exportExcel');

Route::get('/reportPurchaseOrders/filter', 'Apps\Report\ReportPurchaseOrdersCtrl@filterReportPurchaseOrders')->name('reportPurchaseOrders.filterReportPurchaseOrders');
Route::get('/reportPurchaseOrders/exportExcel', 'Apps\Report\ReportPurchaseOrdersCtrl@exportExcel')->name('reportPurchaseOrders.exportExcel');

Route::get('/reportPurchaseOrderRewards/filter', 'Apps\Report\ReportPurchaseOrderRewardsCtrl@filterReportPurchaseOrderRewards')->name('reportPurchaseOrderRewards.filterReportPurchaseOrderRewards');
Route::get('/reportPurchaseOrderRewards/exportExcel', 'Apps\Report\ReportPurchaseOrderRewardsCtrl@exportExcel')->name('reportPurchaseOrderRewards.exportExcel');

Route::get('/reportStockOpname/filter', 'Apps\Report\ReportStockOpnameCtrl@filterReportStockOpname')->name('reportStockOpname.filterReportStockOpname');
Route::get('/reportStockOpname/exportExcel', 'Apps\Report\ReportStockOpnameCtrl@exportExcel')->name('reportStockOpname.exportExcel');

Route::get('/reportStockOpnameReward/filter', 'Apps\Report\ReportStockOpnameRewardCtrl@filterReportStockOpnameReward')->name('reportStockOpnameReward.filterReportStockOpnameReward');
Route::get('/reportStockOpnameReward/exportExcel', 'Apps\Report\ReportStockOpnameRewardCtrl@exportExcel')->name('reportStockOpnameReward.exportExcel');

Route::get('/reportBalanceSheet/getCountData', 'Apps\Report\ReportBalanceSheetCtrl@index')->name('dashboard.index');
Route::get('/reportBalanceSheet/exportExcel', 'Apps\Report\ReportBalanceSheetCtrl@exportExcel')->name('reportBalanceSheet.exportExcel');

Route::get('/reportIncomeStatement/filter', 'Apps\Report\ReportIncomeStatementCtrl@filterReportIncomeStatement')->name('reportIncomeStatement.filterReportIncomeStatement');
Route::get('/reportIncomeStatement/exportExcel', 'Apps\Report\ReportIncomeStatementCtrl@exportExcel')->name('reportIncomeStatement.exportExcel');

// HISTORY ROUTE
Route::get('/historyLogin/list', 'Apps\History\HistoryLoginCtrl@index')->name('historyLogin.index');
Route::get('/historyTrChangeBooks/list', 'Apps\History\HistoryTrChangeBooksCtrl@index')->name('historyTrChangeBooks.index');
Route::get('/historyTrChangeStamps/list', 'Apps\History\HistoryTrChangeStampsCtrl@index')->name('historyTrChangeStamps.index');
Route::get('/historyTrPayments/list', 'Apps\History\HistoryTrPaymentsCtrl@index')->name('historyTrPayments.index');
Route::get('/historyTrPurchaseOrders/list', 'Apps\History\HistoryTrPurchaseOrdersCtrl@index')->name('historyTrPurchaseOrders.index');
Route::get('/historyTrPurchaseOrderStamps/list', 'Apps\History\HistoryTrPurchaseOrderStampsCtrl@index')->name('historyTrPurchaseOrderStamps.index');
Route::get('/historyTrStockOpname/list', 'Apps\History\HistoryTrStockOpnameCtrl@index')->name('historyTrStockOpname.index');

Route::get('/database/list', 'Apps\Database\DatabaseCtrl@index')->name('database.index');
Route::post('/database/backup', 'Apps\Database\DatabaseCtrl@backup')->name('database.backup');
Route::get('/database/download/{id}', 'Apps\Database\DatabaseCtrl@download')->name('database.download');
