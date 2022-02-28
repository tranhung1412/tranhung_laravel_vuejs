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


Route::get('/home', function () {
    return view('public/index');
});

Auth::routes();

Route::get('/', 'IndexController@index');
//Route::get('/home', 'IndexController@index');
Route::get('/admin', 'HomeController@index')->name('admin');
Route::get('/loginAdmin', function () {
    return view('auth/login');
});
//Route::get('/admin/{path}', 'HomeController@index')->where('path', '([A-z\d-\/_.]+)?');
Route::get('admin/category',[
    'as'=>'category.index',
    'uses'=>'HomeController@index',
    'middleware' =>'checkAcl:Manage Category'
]);
Route::get('admin/user',[
    'as'=>'user.index',
    'uses'=>'HomeController@index',
    'middleware' =>'checkAcl:Manage User'
]);
Route::get('admin/role',[
    'as'=>'role.index',
    'uses'=>'HomeController@index',
    'middleware' =>'checkAcl:Manage Role'
]);
Route::get('admin/product',[
    'as'=>'product.index',
    'uses'=>'HomeController@index',
    'middleware' =>'checkAcl:Manage Product'
]);
Route::get('admin/producttype',[
    'as'=>'producttype.index',
    'uses'=>'HomeController@index',
    'middleware' =>'checkAcl:Manage ProductType'
]);
Route::get('/admin/comment',[
    'as'=>'comment.index',
    'uses'=>'HomeController@index',
    'middleware' =>'checkAcl:Manage Comment'
]);
Route::get('/admin/blog',[
    'as'=>'blog.index',
    'uses'=>'HomeController@index',
    //'middleware' =>'checkAcl:Manage Comment'
]);
Route::get('/admin/{path}', 'HomeController@index')->name('admin');
//Manage Comment
Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::get('/admin/edit-product/{path}', 'HomeController@index');
Route::get('/admin/edit-blog/{path}', 'HomeController@index');
//Route::get('/product-detail/{path}', 'IndexController@index');
//Route::get('/product-list/{path}', 'IndexController@index');
//Route::get('/product-list', 'IndexController@index');
Route::get('/search?keyword={path}', 'IndexController@index');
Route::get('/cart', 'IndexController@index');
Route::get('/blog/{path}', 'IndexController@index');
Route::get('/checkout', 'IndexController@index');
Route::get('/forget-password-admin', 'IndexController@index')->name('get.reset.password.admin');
Route::get('/password-reset-admin', 'IndexController@index')->name('get.send.link.reset.admin');
Route::get('/owl', 'IndexController@index');
Route::get('/login-user', 'IndexController@index');
Route::get('/register-user', 'IndexController@index');
Route::post('/loginAdmin','UserController@loginAdmin')->name('admin.login');
Route::view('/loginAdmin','admin.login')->name('login.admin');
Route::get('/{path}', 'IndexController@index');
Route::get('/{path}/{path2}', 'IndexController@index');
Route::get('/{path}/{path2}/{path3}', 'IndexController@index');
Route::get('/password-reset', 'IndexController@index')->name('get.send.link.reset');
Route::get('/email', 'IndexController@index');
Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
// Route::get('login', function () {
//    return view('admin.hello');
// });
// Route::post('loginAdmin','UserController@loginAdmin')->name('admin.login');
// Route::view('loginAdmin','admin.login')->name('login.admin');

Route::get('forget_password','Auth\ForgotPasswordController@getFormResetPassword')->name('get.reset.password');
// Route::post('forget_password','Auth\ForgotPasswordController@sendCodeResetPassword');
Route::get('password_reset','Auth\ForgotPasswordController@resetPassword');
// Route::post('password_reset','Auth\ForgotPasswordController@saveResetPassword');
//Route::post('forget_passwordAdmin','Auth\ForgotPasswordController@sendCodeAdminResetPassword');
