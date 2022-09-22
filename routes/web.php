<?php

use App\Http\Controllers\Web\users\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\advertisements\AdvertisementController;
use App\Http\Controllers\Web\coins\CoinController;
use App\Http\Controllers\Web\admins\AdminController;
use App\Http\Controllers\Web\advertisements\MiningStatusController;
use App\Http\Controllers\Web\coins\CoinLogController;
use App\Http\Controllers\Web\services\banners\BannerController;
use App\Http\Controllers\Web\transactions\TransactionController;
use App\Http\Controllers\Web\products\ProductsController;
use App\Http\Controllers\Web\services\customers\CustomersController;
use App\Http\Controllers\Web\services\notices\NoticeController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\products\OrderController;
use App\Http\Controllers\Web\services\alerts\AlertController;
use App\Http\Controllers\Web\services\QA\QAController;

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


Auth::routes(['register' => false]);


Route::prefix('admin')->as('admin.')->middleware('auth')->group(function () {

    // General
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('change-language/{locale}', 'changeLanguage')->name('change-language');
        Route::get('/fetch-data','fetchData')->name('main.fetchData');
        Route::get('/ranking-monitor','rankingMonitor')->name('rankingMonitor');
        Route::get('/ranking-order','rankingOrder')->name('rankingOrder');
    });

    // User
    Route::controller(UserController::class)->group(function () {
        Route::prefix('users')-> as('users.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('fetch-data', 'fetchData')->name('fetchData');
            Route::delete('delete', 'deleteUser')->name('deleteUser');
            Route::get('{id}/show', 'show')->name('show');
            Route::get('{id}/delete-image', 'delete_image')->name('delete.image');
            Route::post('{id}/edit', 'edit')->name('edit');
            Route::put('change-status-user', 'changeStatusMember')->name('changeStatusMember');
            Route::get('/wallet/{id}' , 'wallet')->name('wallet');
            Route::get('/product-inventory/{id}' , 'productInventory')->name('productInventory');
            Route::post('/mining-status' , 'miningStatus')->name('miningStatus');
        });
    });

    // Coin
    Route::prefix('coins')-> as('coins.')->group(function () {
        Route::controller(CoinController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/coin-swap-setting', 'coin_swap_setting')->name('coin_swap_settings');
            Route::get('/fetch-data','fetchData')->name('fetchData');
            Route::post('/detail-or-update','detailOrUpdate')->name('detailOrUpdate');
            Route::post('/detail-coin-swap-setting','detailCoinSwapSetting')->name('detailCoinSwapSetting');
            Route::post('update-swap-setting','updateSwapSetting')->name('updateSwapSetting');
        });

        Route::controller(CoinLogController::class)->group(function () {
            Route::get('/log', 'index')->name('log.index');
            Route::get('/witdraw-confirm-list', 'witdrawConfirmList')->name('log.witdrawConfirmList');
            Route::get('/log/fetch-data','fetchData')->name('log.fetchData');
            Route::get('/log/fetch-data-witdraw','fetchDataWitdraw')->name('log.fetchDataWitdraw');
            Route::put('/change-status-coin', 'witdrawConfirm')->name('log.witdrawConfirm');
        });
    });

    // Product
    Route::prefix('products')->as('products.')->group(function () {
   
        Route::controller(ProductsController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('register', 'create')->name('register');
                Route::post('register', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}/edit', 'update')->name('update');
                Route::get('/fetch-data','fetchData')->name('fetchData');
                Route::put('change-status-product', 'changeStatus')->name('changeStatus');
                Route::delete('/delete', 'delete')->name('delete');
        });

        // Order
        Route::controller(OrderController::class)->group(function () {
            Route::prefix('orders')->as('orders.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/fetch-data', 'fetchData')->name('fetchData');
                Route::get('/status-sales', 'status_sales')->name('status.sales');
                Route::get('/sales-fetchdata', 'status_sales_fetchData')->name('sales.fetchdata');
                Route::post('revenue-detail', 'revenue_detail')->name('revenue_detail');
            });
        });
    });

    // Advertisement
    Route::prefix('advertisements')->as('advertisements.')->group(function () {
        Route::controller(AdvertisementController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('register', 'create')->name('register');
            Route::get('audit', 'audit')->name('audit');
            Route::get('{id}/edit', 'edit')->name('edit');
            Route::get('{id}/delete-video', 'delete_video')->name('delete_video');
            Route::get('/fetch-data', 'fetchData')->name('fetchData');
            Route::get('/fetch-data-monitor', 'fetchDataMonitor')->name('fetchDataMonitor');
            Route::delete('/delete', 'delete')->name('delete');
            Route::put('/change-status', 'changeStatus')->name('changeStatus');
            Route::get('/advertising-monitoring', 'monitoring')->name('monitoring');
            Route::get('/Mining-amount-ranking', 'MiningAmountRanking')->name('MiningAmountRanking');
            Route::post('/register-ads', 'register_ads')->name('create');
            Route::post('{id}/update-ads', 'update')->name('update_ads');
            Route::post('upload-video', 'upload_video')->name('upload.video');
            Route::get('ads-statistics', 'ads_statistics')->name('ads_statistics');
            Route::get('fetch-mining', 'fetch_table_mining')->name('ads_statistics.table_mining');
            Route::get('fetch-datatable-ads', 'datatable_ads')->name('ads_statistics.datatable_ads');
            Route::get('fetch-data-chart', 'fetch_data_chart')->name('ads_statistics.fetchDataChart');
        });

        // Mining Status
        Route::controller(MiningStatusController::class)->group(function () {
            Route::get('/mining-status', 'index')->name('mining_status');
            Route::get('/mining-status/fetch-data', 'fetchData')->name('mining_status.fetch_data');
        });
    });

    // Services
    Route::prefix('services')->as('services.')->group(function () {
        Route::controller(NoticeController::class)->group(function () {
            Route::prefix('notices')->as('notices.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/fetch-data', 'fetchData')->name('fetchData');
                Route::put('/change-status', 'changeStatus')->name('changeStatus');
                Route::delete('/delete', 'delete')->name('delete');
                Route::get('register', 'create')->name('register');
                Route::post('register', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}/edit', 'update')->name('update');
                Route::post('/upload-video', 'upload_video')->name('upload_video');
            });
        });
        Route::controller(BannerController::class)->group(function () {
            Route::prefix('banners')->as('banners.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/update', 'update')->name('update');
            });
        });
        Route::controller(QAController::class)->group(function () {
            Route::prefix('qa')->as('qa.')->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/fetch-data', 'fetchData')->name('fetchData');
                Route::put('/change-status', 'changeStatus')->name('changeStatus');
                Route::delete('/delete', 'delete')->name('delete');
                Route::get('/register', 'register')->name('register');
                Route::post('/register', 'store')->name('store');
                Route::get('/detail/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
            });
        });
        Route::controller(AlertController::class)->group(function () {
            Route::prefix('alerts')->as('alerts.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/update', 'update')->name('update');
            });
        });
    });

 

    // Account
    Route::controller(AdminController::class)->group(function () {
        Route::prefix('admins')->as('admins.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/fetch-data', 'fetchData')->name('fetchData');
            Route::delete('delete', 'deleteAdmin')->name('deleteAdmin');
            Route::put('change-status-admin', 'changeStatusAdmin')->name('changeStatusAdmin');
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}/edit', 'update')->name('update');
        });
    });


   
});
