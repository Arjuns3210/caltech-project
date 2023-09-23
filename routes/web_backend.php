<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// controllers

Route::get('/', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@login');
Route::get('login', 'LoginController@loadLoginView')->name('webadmin/login');
Route::get('certificates/{id}', 'CertificateController@viewCertificate')->name('shared_certificate_view');

// FOR RESET PASSWORD
Route::get('/forgot-password', 'LoginController@forgotPassword')->name('password.request');
Route::post('/forgot-password', 'LoginController@forgotPasswordStore')->name('password.email');
Route::get('/reset-password/{token}/{email}', 'LoginController@passwordReset')->name('password.reset')->middleware('signed');
Route::post('/reset-password', 'LoginController@passwordUpdate')->name('password.update');
Route::group(['middleware' => ['customAuth']], function () {
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('admin_dashboard', 'DashboardController@adminDashboard')->name('admin_dashboard');
	Route::get('staff_dashboard', 'DashboardController@staffDashboard')->name('staff_dashboard');
	Route::get('index', 'DashboardController@genericDashboard')->name('index');
	Route::post('admin_certificate_dashboard_chart', 'DashboardController@certificateDashboardChart')->name('admin_certificate_dashboard_chart');

	//
	Route::get('dashboard/test', 'DashboardController@index_phpinfo');

	//profile
	Route::get('/profile', 'AdminController@profile');
	Route::post('/updateProfile', 'AdminController@updateProfile');

	//change password
	Route::get('/updatePassword', 'AdminController@updatePassword');
	Route::post('/resetPassword', 'AdminController@resetPassword');

	//staff
	Route::get('/staff', 'StaffController@index');
	Route::post('/staff_data', 'StaffController@staffData')->name('staff_data');
	Route::get('/staff_add', 'StaffController@addStaff');
	Route::post('/saveStaff', 'StaffController@saveStaff');
	Route::get('/staff_edit/{id}', 'StaffController@editStaff');
	Route::post('/publishStaff', 'StaffController@publishStaff');
	Route::get('/staff_view/{id}', 'StaffController@view');
	Route::get('/staff_delete/{id}', 'StaffController@deleteStaff');

	//product
	Route::get('/products', 'ProductsController@index');
	Route::post('/products_data', 'ProductsController@productsData')->name('products_data');
	Route::get('/products_add', 'ProductsController@addProduct');
	Route::post('/saveproducts', 'ProductsController@saveproducts');
	Route::post('/publishproducts', 'ProductsController@publishproducts');
	Route::get('/products_view/{id}', 'ProductsController@view');
	Route::get('/products_edit/{id}', 'ProductsController@editproduct');
	Route::get('/products_delete/{id}', 'ProductsController@deleteproduct');
	Route::get('/product/{id}', 'ProductsController@singleProduct');


	//Certificate 
	Route::get('/certificate', 'CertificateController@index');
	Route::get('/certificate_add', 'CertificateController@addcertificate');
	Route::post('/saveCertificate', 'CertificateController@saveCertificate');
	Route::post('/certificate_data', 'CertificateController@certificateData')->name('certificate_data');
	Route::get('/certificate_pdf/{id}', 'CertificateController@certificatePdf')->name('invoice_pdf');
	Route::get('/certificate_view/{id}', 'CertificateController@view');
	Route::get('/certificate_edit/{id}', 'CertificateController@editCertificate');
	Route::get('/certificate_delete/{id}', 'CertificateController@deleteCertificate');
	Route::get('/share_certificate/{id}', 'CertificateController@share_certificate');
	Route::post('/certificate/sendEmail', 'CertificateController@sendEmail');

	//Client 
	Route::get('/client', 'ClientController@index');
	Route::post('/client_data', 'ClientController@clientData')->name('client_data');
	Route::get('/client_add', 'ClientController@addClient');
	Route::post('/saveClient', 'ClientController@saveClient');
	Route::get('/client_view/{id}', 'ClientController@view');
	Route::get('/client_edit/{id}', 'ClientController@editClient');
	Route::get('/client_delete/{id}', 'ClientController@deleteClient');
	Route::post('/publishClient', 'ClientController@publishClient');
	Route::get('/client/{id}', 'ClientController@singleClient');

	//reports
	Route::get('/report','ReportController@index');
	Route::get('/client_report','ReportController@client_report');
	Route::post('/DataReport','ReportController@export');
	Route::post('/ClientReport','ReportController@client');
});

// routes
Route::get('/logout', function () {
	session()->forget('data');
	return redirect('/webadmin');
});
