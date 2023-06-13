<?php

use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersProductsController;
use App\Http\Controllers\PasswordSecurityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectsUsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::post('/2faVerify', function ()
{
    return redirect()->route('index');
})->name('2fa.verify')->middleware('2fa');

Route::group(['as' => '2fa.', 'prefix' => '2fa', 'middleware' => ['auth', '2fa']], function ()
{
    Route::get('show', [PasswordSecurityController::class, 'show'])->name('show');
    Route::post('generateSecret', [PasswordSecurityController::class, 'generateSecret'])->name('generateSecret');
    Route::post('enable', [PasswordSecurityController::class, 'enable'])->name('enable');
    Route::post('disable', [PasswordSecurityController::class, 'disable'])->name('disable');
});
Route::group(['prefix' => 'auth/{provider}'], function ()
{
    Route::get('', [SocialController::class, 'redirectToProvider']);
    Route::get('callback', [SocialController::class, 'handleProviderCallback']);
});

Route::get('', [ArticleController::class, 'index'])->name('index');

Route::group(['as' => 'article.', 'prefix' => 'articles'], function ()
{
    Route::get('{article}/show', [ArticleController::class, 'show'])->name('show');
});

Route::group(['as' => 'projects.', 'prefix' => 'projects'], function ()
{
    Route::get('', [ProjectController::class, 'home'])->name('index');
    Route::get('{project}/show', [ProjectController::class, 'show'])->name('show');
});

Route::group(['as' => 'products.', 'prefix' => 'products'], function ()
{
    Route::get('', [ProductController::class, 'index'])->name('index');
    Route::get('{product}/show', [ProductController::class, 'show'])->name('show');
});

Route::group(['as' => 'cart.', 'prefix' => 'cart'], function ()
{
    Route::get('', [CartController::class, 'index'])->name('index');
    Route::get('data', [CartController::class, 'customerData'])->name('data');
    Route::post('store/data', [CartController::class, 'storeCustomerData'])->name('store.data');
    Route::get('confirm', [CartController::class, 'confirm'])->name('confirm');
    Route::get('confirmed', [CartController::class, 'confirmed'])->name('confirmed');
    Route::group(['prefix' => '{product}'], function ()
    {
        Route::post('add', [CartController::class, 'add'])->name('add');
        Route::post('update', [CartController::class, 'update'])->name('update');
        Route::delete('destroy', [CartController::class, 'destroy'])->name('destroy');
    });
});

Route::group(['as' => 'order.', 'prefix' => 'order'], function ()
{
    Route::post('', [OrderController::class, 'order'])->name('order');
    Route::get('ordered', [OrderController::class, 'ordered'])->name('ordered');
});

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', '2fa']], function ()
{
    Route::group(['as' => 'article.', 'prefix' => 'articles'], function ()
    {
        Route::get('', [ArticleController::class, 'adminIndex'])->name('index');
        Route::get('search', [SearchController::class, 'articleAdminSearch'])->name('search');
        Route::get('create', [ArticleController::class, 'adminCreate'])->name('create');
        Route::post('store', [ArticleController::class, 'adminStore'])->name('store');
        Route::group(['prefix' => '{article}'], function ()
        {
            Route::get('edit', [ArticleController::class, 'adminEdit'])->name('edit');
            Route::put('update', [ArticleController::class, 'adminUpdate'])->name('update');
            Route::get('delete', [ArticleController::class, 'delete'])->name('delete');
            Route::put('delete/image', [ArticleController::class, 'deleteImage'])->name('delete.image');
        });
    });
    Route::group(['as' => 'users.', 'prefix' => 'users'], function ()
    {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('search', [SearchController::class, 'userSearch'])->name('search');
        Route::group(['prefix' => '{user}'], function ()
        {
            Route::get('edit', [UserController::class, 'adminEdit'])->name('edit');
            Route::put('update', [UserController::class, 'adminUpdate'])->name('update');
            Route::delete('delete', [UserController::class, 'delete'])->name('delete');
        });
    });
    Route::group(['as' => 'role.', 'prefix' => 'roles'], function ()
    {
        Route::get('', [RoleController::class, 'index'])->name('index');
        Route::get('search', [SearchController::class, 'roleSearch'])->name('search');
        Route::get('create', [RoleController::class, 'create'])->name('create');
        Route::post('store', [RoleController::class, 'store'])->name('store');
        Route::group(['prefix' => '{role}'], function ()
        {
            Route::get('edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('update', [RoleController::class, 'update'])->name('update');
            Route::delete('delete', [RoleController::class, 'delete'])->name('delete');
        });
    });
    Route::group(['as' => 'projects.', 'prefix' => 'projects'], function ()
    {
        Route::get('', [ProjectController::class, 'adminIndex'])->name('index');
        Route::get('search', [SearchController::class, 'projectAdminSearch'])->name('search');
        Route::get('create', [ProjectController::class, 'create'])->name('create');
        Route::post('store', [ProjectController::class, 'store'])->name('store');
        Route::delete('image/{project}/delete', [ProjectController::class, 'destroyImg'])->name('destroy.image');
        Route::group(['prefix' => '{project}'], function ()
        {
            Route::get('edit', [ProjectController::class, 'editInfo'])->name('edit.info');
            Route::put('update', [ProjectController::class, 'updateInfo'])->name('update.info');
            Route::delete('delete', [ProjectController::class, 'destroy'])->name('destroy');
        });
        Route::group(['as' => 'users.', 'prefix' => '{project}/users'], function ()
        {
            Route::get('', [ProjectsUsersController::class, 'index'])->name('index');
            Route::get('search', [SearchController::class, 'projectAdminUserSearch'])->name('search');
            Route::get('create', [ProjectsUsersController::class, 'create'])->name('create');
            Route::post('store', [ProjectsUsersController::class, 'store'])->name('store');
        });
        Route::group(['as' => 'users.', 'prefix' => 'users/{projectUser}'], function ()
        {
            Route::get('edit', [ProjectsUsersController::class, 'edit'])->name('edit');
            Route::put('update', [ProjectsUsersController::class, 'update'])->name('update');
            Route::delete('delete', [ProjectsUsersController::class, 'destroy'])->name('destroy');
        });
        Route::group(['as' => 'tasks.', 'prefix' => '{project}/tasks'], function ()
        {
            Route::get('open', [TaskController::class, 'adminOpen'])->name('open');
            Route::get('open/search', [SearchController::class, 'adminOpenTaskSearch'])->name('open.search');
            Route::get('completed', [TaskController::class, 'adminCompleted'])->name('completed');
            Route::get('completed/search', [SearchController::class, 'adminCompletedTaskSearch'])->name('completed.search');
            Route::get('create', [TaskController::class, 'create'])->name('create');
            Route::post('store', [TaskController::class, 'store'])->name('store');
            Route::group(['prefix' => '{task}'], function ()
            {
                Route::get('edit', [TaskController::class, 'edit'])->name('edit');
                Route::put('update', [TaskController::class, 'update'])->name('update');
                Route::delete('destroy', [TaskController::class, 'destroy'])->name('destroy');
            });
        });
        Route::group(['as' => 'company.', 'prefix' => '{project}/company'], function ()
        {
            Route::get('', [ProjectController::class, 'company'])->name('index');
        });
    });
    Route::group(['as' => 'companies.', 'prefix' => 'companies'], function ()
    {
        Route::get('', [CompanyController::class, 'index'])->name('index');
        Route::get('search', [SearchController::class, 'companySearch'])->name('search');
        Route::get('create', [CompanyController::class, 'create'])->name('create');
        Route::post('store', [CompanyController::class, 'store'])->name('store');
        Route::group(['prefix' => '{company}'], function ()
        {
            Route::get('edit', [CompanyController::class, 'edit'])->name('edit');
            Route::put('update', [CompanyController::class, 'update'])->name('update');
            Route::delete('destroy', [CompanyController::class, 'destroy'])->name('destroy');
        });
        Route::group(['as' => 'employees.', 'prefix' => '{company}/employee'], function ()
        {
            Route::post('', [EmployeeController::class, 'getEmployees'])->name('get.employees');
            Route::post('store', [EmployeeController::class, 'store'])->name('store');
            Route::group(['prefix' => '{employee}'], function ()
            {
                Route::put('update', [EmployeeController::class, 'update'])->name('update');
                Route::delete('destroy', [EmployeeController::class, 'destroy'])->name('destroy');
            });
        });
    });
    Route::group(['as' => 'products.', 'prefix' => 'products'], function ()
    {
        Route::get('', [ProductController::class, 'adminIndex'])->name('index');
        Route::get('search', [SearchController::class, 'productSearch'])->name('search');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::group(['prefix' => '{product}'], function ()
        {
            Route::get('edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('update', [ProductController::class, 'update'])->name('update');
            Route::delete('destroy', [ProductController::class, 'destroy'])->name('destroy');
            Route::group(['as' => 'accessories.', 'prefix' => 'accessories'], function ()
            {
                Route::post('store', [AccessoryController::class, 'store'])->name('store');
                Route::group(['prefix' => '{accessory}'], function ()
                {
                    Route::put('update', [AccessoryController::class, 'update'])->name('update');
                    Route::delete('destroy', [AccessoryController::class, 'destroy'])->name('destroy');
                });
            });
        });
    });
    Route::group(['as' => 'orders.', 'prefix' => 'orders'], function ()
    {
        Route::get('', [OrderController::class, 'index'])->name('index');
        Route::get('search', [SearchController::class, 'orderSearch'])->name('search');
        Route::delete('clearsession', [OrderController::class, 'clearSession'])->name('clear.session');
        Route::group(['as' => 'create.', 'prefix' => 'create'], function ()
        {
            Route::get('customer', [OrderController::class, 'createCustomer'])->name('customer');
            Route::get('products', [OrderController::class, 'productsAddCreate'])->name('products');
            Route::get('confirm', [OrderController::class, 'confirmCreate'])->name('confirm');
        });
        Route::group(['as' => 'store.'], function ()
        {
            Route::post('customer/store', [OrderController::class, 'storeCustomer'])->name('customer');
            Route::post('product/store', [OrderController::class, 'productStoreCreate'])->name('product');
            Route::post('store', [OrderController::class, 'adminStore'])->name('order');
        });
        Route::group(['prefix' => 'product/{product}'], function ()
        {
            Route::put('update', [OrderController::class, 'updateProductCreate'])->name('update.product');
            Route::delete('delete', [OrderController::class, 'deleteProductCreate'])->name('delete.product');
        });
        Route::group(['prefix' => '{order}'], function ()
        {
            Route::group(['prefix' => 'edit', 'as' => 'edit.'], function ()
            {
                Route::get('', [OrderController::class, 'edit'])->name('index');
                Route::get('mail', [OrderController::class, 'mailOrder'])->name('mail');
                Route::post('add', [OrdersProductsController::class, 'add'])->name('add');
                Route::put('change/status', [OrderController::class, 'changeStatus'])->name('change.status');
                Route::group(['prefix' => 'product/{product}', 'as' => 'product.'], function ()
                {
                    Route::put('quantity', [OrdersProductsController::class, 'quantity'])->name('quantity');
                    Route::put('discount', [OrdersProductsController::class, 'discount'])->name('discount');
                    Route::delete('destroy', [OrdersProductsController::class, 'destroy'])->name('destroy');
                });
            });
            Route::put('update', [OrderController::class, 'update'])->name('update');
            Route::delete('destroy', [OrderController::class, 'destroy'])->name('destroy');
            Route::get('downloadPDF', [OrderController::class, 'downloadPDF'])->name('downloadPDF');
        });
    });
    Route::group(['as' => 'category.', 'prefix' => 'category'], function ()
    {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('search', [SearchController::class, 'categorySearch'])->name('search');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::group(['prefix' => '{category}'], function ()
        {
            Route::put('update', [CategoryController::class, 'update'])->name('update');
            Route::delete('destroy', [CategoryController::class, 'destroy'])->name('destroy');
        });
    });
});

Route::group(['as' => 'user.', 'prefix' => 'user', 'middleware' => ['auth', '2fa']], function ()
{
    Route::group(['as' => 'articles.', 'prefix' => 'articles'], function ()
    {
        Route::get('', [ArticleController::class, 'userIndex'])->name('index');
        Route::get('search', [ArticleController::class, 'articleUserSearch'])->name('search');
        Route::get('create', [ArticleController::class, 'create'])->name('create');
        Route::post('store', [ArticleController::class, 'store'])->name('store');
        Route::group(['prefix' => '{article}'], function ()
        {
            Route::get('edit', [ArticleController::class, 'edit'])->name('edit');
            Route::put('update', [ArticleController::class, 'update'])->name('update');
            Route::get('delete', [ArticleController::class, 'delete'])->name('delete');
            Route::put('delete/image', [ArticleController::class, 'deleteImage'])->name('delete.image');
        });
    });

    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function ()
    {
        Route::get('', [UserController::class, 'profile'])->name('index');
        Route::group(['prefix' => '{user}'], function ()
        {
            Route::get('edit', [UserController::class, 'edit'])->name('edit');
            Route::put('update', [UserController::class, 'update'])->name('update');
            Route::delete('delete', [UserController::class, 'delete'])->name('delete');
        });
    });

    Route::group(['as' => 'tasks.', 'prefix' => 'tasks'], function ()
    {
        Route::get('open', [TaskController::class, 'open'])->name('open');
        Route::get('open/search', [SearchController::class, 'openTaskSearch'])->name('open.search');
        Route::get('completed', [TaskController::class, 'completed'])->name('completed');
        Route::get('completed/search', [SearchController::class, 'completedTaskSearch'])->name('completed.search');
        Route::group(['prefix' => '{task}'], function ()
        {
            Route::put('approve', [TaskController::class, 'approve'])->name('approve');
            Route::put('unapprove', [TaskController::class, 'unapprove'])->name('unapprove');
            Route::put('unapprove/js', [TaskController::class, 'unapproveJS'])->name('unapprove.js');
            Route::get('show', [TaskController::class, 'show'])->name('show');
        });
    });

    Route::group(['as' => 'projects.', 'prefix' => 'projects'], function ()
    {
        Route::get('', [ProjectController::class, 'userIndex'])->name('index');
        Route::get('search', [SearchController::class, 'projectUserSearch'])->name('search');
        Route::get('{project}/show', [ProjectController::class, 'userShow'])->name('show');
    });
});
