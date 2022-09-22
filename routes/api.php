<?php


use App\Http\Controllers\Api\Advertisements\AdvertisementsController;
use App\Http\Controllers\Api\Alerts\AlertController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Banners\BannerController;
use App\Http\Controllers\Api\Coin\CoinController;
use App\Http\Controllers\Api\Nations\NationController;
use App\Http\Controllers\Api\Notices\NoticeController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Orders\OrderController;
use App\Http\Controllers\Api\ProductInventorys\ProductInventoryController;
use App\Http\Controllers\Api\QA\QAController;
use App\Http\Controllers\Api\Wallet\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('change-password', 'change_password');
    Route::get('/redirect/{provider}', 'redirectToProvider');
    Route::get('/callback/{provider}', 'handleProviderCallback');
});

// Register
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('email-verification', 'email_verification');
    Route::post('confirm-email', 'confirm_email');
});

Route::controller(UserController::class)->group(function () {
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('find-account', 'find_account');
    });
});



// Nation
Route::controller(NationController::class)->group(function () {
    Route::prefix('nations')->as('nations.')->group(function () {
        Route::get('/', 'list');
    });
});


Route::middleware('auth:sanctum')->group(function () {

    // Get Auth
    Route::controller(AuthController::class)->group(function () {
        Route::prefix('auth')->as('auth.')->group(function () {
            Route::get('refresh-token', 'refresh')->name('refresh');
            Route::post('logout', 'logout');
        });
    });
    // Member
    Route::controller(UserController::class)->group(function () {
        Route::prefix('users')->as('users.')->group(function () {
            Route::post('update', 'update');
            Route::post('secession', 'secession');
            Route::get('profile', 'profile');
            Route::get('search', 'search');
            Route::post('update-password', 'updatePassword');
            Route::post('upload-image', 'upload_image');
            Route::post('save-device-token', 'saveDeviceToken');
        });
    });
    // Product
    Route::controller(ProductController::class)->group(function () {
        Route::prefix('products')->as('products.')->group(function () {
            Route::get('/', 'index');
            Route::get('list-shop', 'list_shop');
            Route::get('/detail/{id}', 'product_detail');
        });
    });

    // Advertisements
    Route::controller(AdvertisementsController::class)->group(function () {
        Route::prefix('advertisements')->as('advertisements.')->group(function () {
            Route::get('/', 'list');
            Route::get('/detail/{id}', 'detail');
            Route::post('setting-ad', 'setting_ad');
            Route::post('reward-ad', 'reward_ad');
            Route::get('sum-reward', 'sum_reward');
            Route::post('confirm-get-reward', 'confirm_get_reward');
            Route::get('information-setting-ad', 'information_setting_ad');
        });
    });

    //Notice
    Route::controller(NoticeController::class)->group(function () {
        Route::prefix('notices')->as('notices.')->group(function () {
            Route::get('/', 'index');
            Route::get('/detail/{id}', 'show');
        });
    });
    // Order
    Route::controller(OrderController::class)->group(function () {
        Route::prefix('orders')->as('orders.')->group(function () {
            Route::post('buy-product', 'buy_product');
        });
    });
    // Wallet
    Route::controller(WalletController::class)->group(function () {
        Route::prefix('wallets')->as('wallets.')->group(function () {
            Route::get('/', 'wallet');
            Route::get('/detail/{id}', 'detail');
            Route::get('/history-deposit-and-withdraw/{id}', 'history_deposit_and_withdraw');
            Route::post('withdrawal-request', 'withdrawalRequest');
            Route::post('update-wallet/{wallet_id}', 'updateWallet');
            Route::get('/get-deposit-wallet-information', 'getDepositWalletInformation');
        });
    });

    // Product Inventory
     Route::controller(ProductInventoryController::class)->group(function () {
        Route::prefix('product-inventorys')-> as('product_inventorys.')->group(function () {
            Route::get('/', 'index');
            Route::get('/detail/{id}', 'detail');
            Route::get('/price-upgrade/{id}', 'price_upgrade');
            Route::post('repair', 'repair');
            Route::post('upgrade', 'upgrade');
            Route::get('repair-fees/{id}', 'repair_fees');
            Route::post('give-product', 'giveProduct');
        });
    });
    
    // Banners
    Route::controller(BannerController::class)->group(function () {
        Route::prefix('banners')-> as('banners.')->group(function () {
            Route::get('/', 'index');
        });
    });

    // Alerts
    Route::controller(AlertController::class)->group(function () {
        Route::prefix('alerts')-> as('alerts.')->group(function () {
            Route::get('/', 'index');
        });
    });

    // QA
    Route::controller(QAController::class)->group(function () {
        Route::prefix('qas')-> as('qas.')->group(function () {
            Route::get('/', 'index');
            Route::get('/detail/{id}', 'detail');
        });
    });

    // Coin
    Route::controller(CoinController::class)->group(function () {
        Route::prefix('coins')-> as('coins.')->group(function () {
            Route::get('/swap', 'swap');
            Route::get('/', 'index');
            Route::get('/wallet/{coin_id}', 'wallet');
            Route::post('/confirm-swap', 'confirm_swap');
            Route::get('/wallet/{coin_id}', 'wallet');
        });
    });
});
