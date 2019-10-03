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

Route::get('/','HomeController@index');

Route::group(['middleware' => 'auth'], function () {

Route::get('/dashboard','DashBoardController@index')->name('purbachol.dashboard');

//category route
Route::get('/category','CategoriesController@index')->name('category.index');
Route::post('/category/store','CategoriesController@store')->name('category.store');
Route::get('/category/view','CategoriesController@getData')->name('category.getdata');
Route::post('/category/update','CategoriesController@update')->name('category.update');
Route::get('/category/delete-category/{id}','CategoriesController@destroy');

//users route
Route::get('/user','UserController@index')->name('user.index');
Route::post('/user/store','UserController@store')->name('user.store');
Route::get('/user/view','UserController@getData')->name('user.getdata');
Route::post('/user/update','UserController@update')->name('user.update');
Route::get('/user/delete-user/{id}','UserController@destroy');
Route::get('/user/change/password','UserController@getPassword')->name('user.password');
Route::get('/user/check-pwd','UserController@chkPassword');
Route::post('/user/update-password','UserController@updatePassword')->name('user.updatePassword');

//Transaction Route //
Route::get('/transaction','TransactionController@index');

Route::get('/getdata','TransactionController@getData');
Route::get('/transaction/getdata','TransactionController@getData')->name('transaction.getdata');
Route::get('/transaction/delete-transaction/{id}','TransactionController@destroy');


//customers route
Route::get('/customer','CustomersController@index')->name('customer.index');
Route::post('/customer/store','CustomersController@store')->name('customer.store');
Route::get('/customer/view','CustomersController@getData')->name('customer.getdata');
Route::post('/customer/update','CustomersController@update')->name('customer.update');
Route::get('/customer/delete-customer/{id}','CustomersController@destroy');
Route::get('/customer/installment/info/{id}','CustomersController@getCu');
Route::get('/customer/installment/getData','CustomersController@getCustomerData')->name('customerInfo.getdata');


// Customer  income All Routes //
Route::get('/customer/commision','CustomersController@CustomerCommision');
Route::get('/customer/cummision/insert','CustomersController@CustomerCommisionInsert');
Route::get('customer/detiels','CustomersController@CustomerDeitels')->name('customer.details');
Route::post('/customer/commision/store','CustomersController@CustomerCommisionstore');
Route::get('customer/cumission/getdata','CustomersController@CustomerCommisionGetData');
Route::get('/customer/commision/delete-customer-commision/{id}','CustomersController@DeleteCostomerCommision');
Route::get('/customer/commission/edit/{id}','CustomersController@EditCustomerCommision');
Route::post('/customer/cummision/update','CustomersController@CustomerCommisionUpdate');
Route::get('/customer/cheack/balance','CustomersController@checks')->name('customer.check');
//End  Customer  income All Routes //

//Customer Installment (Nayeem)
Route::get('/installment','InstallmentController@index')->name('installment.index');
Route::get('/installment/view','InstallmentController@getdata')->name('installment.getdata');
Route::get('/installment/insert','InstallmentController@insert')->name('installment.insert');
Route::get('/installment/getfield','InstallmentController@getfield')->name('installment.getfield');
Route::post('/installment/store','InstallmentController@store')->name('installment.store');
Route::get('/installment/edits/{id}','InstallmentController@edit');
Route::post('/installment/update','InstallmentController@update')->name('installment.update');
Route::get('/installment/delete-installment/{id}','InstallmentController@destroy');
Route::get('/installment/invoice/{id}','InstallmentController@invoice');
Route::get('/installment/invoice/download/{id}','InstallmentController@invoiceDownload')->name('invoice');


//sub category (Showrav)
Route::get('/subcategory','SubCategoryController@index');
Route::post('/subcategory/store','SubCategoryController@store')->name('subcategory.store');
Route::get('/subcategory/getdata','SubCategoryController@getData')->name('subcategory.getdata');
Route::post('/subcategory/update','SubCategoryController@update')->name('subcategory.update');
Route::get('/subcategory/delete-subcategory/{id}','SubCategoryController@destroy');

//vendor all routes//
Route::get('/vendor','VendorController@index')->name('vendor.index');
Route::post('/vendor/store','VendorController@store')->name('vendor.store');
Route::get('/vendor/view','VendorController@getdata')->name('vendor.getdata');
Route::post('/vendor/update','VendorController@update')->name('vendor.update');
Route::get('/vendor/delete-vendor/{id}','VendorController@destroy');
Route::get('/vendor/info/{id}','VendorController@getVendor');
Route::get('vendor/vendor_get_data','VendorController@getVendorData')->name('vendorInfo.getVendorData');

//Company Routes(Nayeem)
Route::get('/company','CompanyController@index')->name('company.index');
Route::get('/company/view','CompanyController@getdata')->name('company.getdata');
Route::post('/company/store','CompanyController@store')->name('company.store');
Route::post('/company/update','CompanyController@update')->name('company.update');
Route::get('/company/delete-company/{id}','CompanyController@destroy');

// Permission (showrav)
Route::get('/permission','PermissionController@index');
Route::post('/role/insert','PermissionController@insert');
Route::post('/permission/insert','PermissionController@Permissioninsert');
Route::post('/permission/getUser','PermissionController@getUser');

//Seles Income//(showrav)
Route::get('/seller/commission','SalesIncomeController@salesShow');
Route::get('/seller/commission/insert','SalesIncomeController@Showinsertform');
Route::post('/seller/commission/store','SalesIncomeController@store');
Route::get('seller/commission/getdata','SalesIncomeController@getData');
Route::get('/seller/commission/edit/{id}','SalesIncomeController@edit');
Route::post('/seles/income/update','SalesIncomeController@update');
Route::get('saller/detiels','SalesIncomeController@sallerdetiels')->name('saller.details');
Route::get('/saleincome/delete-saleincome/{id}','SalesIncomeController@destroy');
Route::get('/seller/cheack/balance','SalesIncomeController@checks')->name('seller.check');

//Branch Routes (Nayeem)
Route::get('/branch','BranchController@index')->name('branch.index');
Route::post('/branch/store','BranchController@store')->name('branch.store');
Route::get('/branch/view','BranchController@getData')->name('branch.getdata');
Route::post('/branch/update','BranchController@update')->name('branch.update');
Route::get('/branch/delete-branch/{id}','BranchController@destroy');

//Sales Person (Nayeem)
Route::get('/salesperson','SalesPersonController@index')->name('salesperson.index');
Route::post('/salesperson/store','SalesPersonController@store')->name('salesperson.store');
Route::get('/salesperson/view','SalesPersonController@getData')->name('salesperson.getdata');
Route::post('/salesperson/update','SalesPersonController@update')->name('salesperson.update');
Route::get('/salesperson/delete-salesperson/{id}','SalesPersonController@destroy');

//Payment (Nayeem)
Route::get('/payment','PaymentController@index')->name('payment.index');
Route::post('/payment/store','PaymentController@store')->name('payment.store');
Route::get('/payment/view','PaymentController@getData')->name('payment.getdata');
Route::post('/payment/update','PaymentController@update')->name('payment.update');
Route::get('/payment/delete-payment/{id}','PaymentController@destroy');

//Account (Nayeem)
Route::get('/account','AccountController@index')->name('account.index');
Route::post('/account/store','AccountController@store')->name('account.store');
Route::get('/account/view','AccountController@getData')->name('account.getdata');
Route::post('/account/update','AccountController@update')->name('account.update');
Route::get('/account/delete-account/{id}','AccountController@destroy');

//transfer (Nayeem)
Route::get('/transfer','TransferController@index')->name('transfer.index');
Route::post('/transfer/store','TransferController@store')->name('transfer.store');
Route::get('/transfer/view','TransferController@getData')->name('transfer.getdata');
Route::post('/transfer/checkBalance','TransferController@checkBalance');

//Booking Route (Nayeem)
Route::get('/booking','BookingController@index')->name('booking.index');
Route::get('/booking/view','BookingController@getData')->name('booking.getdata');
Route::get('/booking/insert','BookingController@insert')->name('booking.insert');
Route::get('/booking/subcategory','BookingController@subcategory')->name('booking.subcategory');
Route::get('/booking/company','BookingController@company')->name('booking.company');
Route::get('/booking/sqft','BookingController@sqft')->name('booking.sqft');
Route::post('/booking/store','BookingController@store')->name('booking.store');
Route::get('/booking/edit/{id}','BookingController@edit')->name('booking.edit');
Route::post('/booking/update','BookingController@update')->name('booking.update');
Route::get('/booking/delete-booking/{id}','BookingController@destroy');
Route::get('/booking/customer/installment/{id}','BookingController@getCI');
Route::get('/booking/customer/installemnt/getData','BookingController@getBookingData')->name('bookingInfo.getdata');

//other income Route
Route::get('/other/income','OtherIncomeController@index')->name('other.index');
Route::get('/other/income/create','OtherIncomeController@create')->name('other.create');
Route::post('/other/income/store','OtherIncomeController@store')->name('other.store');
Route::get('/other/income/getdata','OtherIncomeController@getData')->name('other.getdata');
Route::get('/other/income/edit/{id}','OtherIncomeController@edit');
Route::post('/other/income/update','OtherIncomeController@update')->name('other.update');
Route::get('/other/delete-other/{id}','OtherIncomeController@destroy');

//Income Reports Route
Route::get('/report/income/summary', 'IncomeReportController@incomeSummary')->name('report.income');
Route::get('/report/booking/summary', 'IncomeReportController@bookingSummary')->name('report.booking');
Route::get('/report/other/summary', 'IncomeReportController@otherSummary')->name('report.other');

//Expense Reports Route
Route::get('/report/sales_commission/summary', 'ExpenseReportController@sales')->name('report.sales');
Route::get('/report/customer_commisision/summary', 'ExpenseReportController@customer')->name('report.customer');
Route::get('/report/vendor/summary', 'ExpenseReportController@vendor')->name('report.vendor');

//expenses vendor payment
Route::get('/expenses/vendor','VendorPaymentController@index')->name('vendorPayment.index');
Route::get('/expenses/vendor/create','VendorPaymentController@create')->name('vendorCreate.create');
Route::get('/expenses/vendor/check','VendorPaymentController@check')->name('vendorCheck.check');
Route::post('/expenses/vendor/store','VendorPaymentController@store')->name('vendorStore.store');
Route::get('/expenses/vendor/getdata','VendorPaymentController@getData')->name('vendors.getdata');
Route::get('/expenses/vendor/edit/{id}','VendorPaymentController@edit');
Route::post('/expenses/vendor/update','VendorPaymentController@update')->name('vendors.update');

});
Auth::routes();

// Password reset link request routes...
Route::get('/forgot_password', 'PasswordController@getEmail');
