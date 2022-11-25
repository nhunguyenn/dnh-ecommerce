<?php

use Illuminate\Support\Facades\Route;

// Admin Controller
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\AdminSupplierController;
use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminColorAttributesController;
use App\Http\Controllers\admin\AdminDeliveryController;
use App\Http\Controllers\admin\AdminOperationHistoryController;
use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\admin\AdminTaxController;
use App\Http\Controllers\admin\AdminRelatedProductController;
use App\Http\Controllers\admin\AdminProductController;
use App\Http\Controllers\admin\AdminProductDiscountController;
use App\Http\Controllers\admin\AdminProductToLayoutController;
use App\Http\Controllers\admin\AdminRequestController;
use App\Http\Controllers\admin\AdminSizeAttributesController;
use App\Http\Controllers\admin\AdminVoucherController;
use App\Http\Controllers\admin\AuthAdminController;
use App\Http\Controllers\clients\AuthClientController;
use App\Http\Controllers\clients\CartController;
use App\Http\Controllers\clients\CheckoutController;
use App\Http\Controllers\clients\HomeController;
use App\Http\Controllers\clients\ProductController;
use App\Http\Controllers\clients\PurchaseController;

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

/*
|--------------------------------------------------------------------------
| CLIENT
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthClientController::class, 'login'])->name('client.auth.login');
Route::post('/handleLogin', [AuthClientController::class, 'handleLogin'])->name('client.auth.handleLogin');

Route::get('/register', [AuthClientController::class, 'register'])->name('client.auth.register');
Route::post('/handleRegister', [AuthClientController::class, 'handleRegister'])->name('client.auth.handleRegister');

Route::get('/logout', [AuthClientController::class, 'logout'])->name('client.auth.logout');

Route::get('/', [HomeController::class, 'index'])->name('client.home');

Route::prefix('product/{id}-{slug}')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('client.detail');
    Route::middleware('client.auth.login')->post('/handleAddToCart', [ProductController::class, 'handleAddToCart'])->name('client.detail.handleAddToCart');
});

Route::middleware('client.auth.login')->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('client.cart');
    Route::post('/handleCrudCart', [CartController::class, 'handleCrudCart'])->name('client.cart.handleCrudCart');
});

Route::middleware('client.auth.login')->prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('client.checkout');
    Route::post('/handleCrudCheckout', [CheckoutController::class, 'handleCrudCheckout'])->name('client.checkout.handleCrudCheckout');
});

Route::middleware('client.auth.login')->prefix('purchase')->group(function () {
    Route::get('/', [PurchaseController::class, 'index'])->name('client.purchase');
    Route::post('/handlePurchase', [PurchaseController::class, 'handlePurchase'])->name('client.purchase.handlePurchase');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthAdminController::class, 'login'])->name('admin.auth.login');
    Route::post('/handleLogin', [AuthAdminController::class, 'handleLogin'])->name('admin.auth.handleLogin');

    Route::get('/logout', [AuthAdminController::class, 'logout'])->name('admin.auth.logout');
});

Route::middleware('admin.auth.login')->prefix('admin')->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');

    Route::prefix('supplier')->group(function () {
        Route::get('/list', [AdminSupplierController::class, 'list'])->name('admin.supplier.list');
        Route::post('/handleCrudSupplier', [AdminSupplierController::class, 'handleCrudSupplier'])->name('admin.supplier.handleCrudSupplier');
    });

    Route::prefix('category')->group(function () {
        Route::get('/theme', [AdminCategoryController::class, 'indexTheme'])->name('admin.category.theme');
        Route::post('/handleCrudTheme', [AdminCategoryController::class, 'handleCrudTheme'])->name('admin.category.handleCrudTheme');

        Route::get('/group', [AdminCategoryController::class, 'indexGroup'])->name('admin.category.group');
        Route::post('/handleCrudGroup', [AdminCategoryController::class, 'handleCrudGroup'])->name('admin.category.handleCrudGroup');
    });

    Route::prefix('tax')->group(function () {
        Route::get('/', [AdminTaxController::class, 'index'])->name('admin.tax');
        Route::post('/handleCrudTax', [AdminTaxController::class, 'handleCrudTax'])->name('admin.tax.handleCrudTax');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.product');
        Route::get('/createProduct', [AdminProductController::class, 'createProduct'])->name('admin.product.createProduct');
        Route::post('/handleCrudProduct', [AdminProductController::class, 'handleCrudProduct'])->name('admin.product.handleCrudProduct');

        Route::get('/discount', [AdminProductDiscountController::class, 'index'])->name('admin.product.discount');
        Route::post('/handleCrudProductDiscount', [AdminProductDiscountController::class, 'handleCrudProductDiscount'])->name('admin.product.handleCrudProductDiscount');
    });

    Route::prefix('advertisement')->group(function () {
        Route::get('/related', [AdminRelatedProductController::class, 'index'])->name('admin.advertisement.related');
        Route::post('/handleCrudRelatedProduct', [AdminRelatedProductController::class, 'handleCrudRelatedProduct'])->name('admin.advertisement.handleCrudRelatedProduct');

        Route::get('/banner', [AdminProductToLayoutController::class, 'index'])->name('admin.advertisement.banner');
        Route::post('/handleCrudBanner', [AdminProductToLayoutController::class, 'handleCrudBanner'])->name('admin.advertisement.handleCrudBanner');
    });

    Route::prefix('attributes')->group(function () {
        Route::get('/size', [AdminSizeAttributesController::class, 'index'])->name('admin.attributes.size');
        Route::post('/handleCrudSizeAttributes', [AdminSizeAttributesController::class, 'handleCrudSizeAttributes'])->name('admin.attributes.handleCrudSizeAttributes');

        Route::get('/color', [AdminColorAttributesController::class, 'index'])->name('admin.attributes.color');
        Route::post('/handleCrudColorAttribute', [AdminColorAttributesController::class, 'handleCrudColorAttribute'])->name('admin.attributes.handleCrudColorAttribute');
    });

    Route::prefix('delivery')->group(function () {
        Route::get('/', [AdminDeliveryController::class, 'index'])->name('admin.delivery');
        Route::post('/handleCrudDelivery', [AdminDeliveryController::class, 'handleCrudDelivery'])->name('admin.delivery.handleCrudDelivery');
    });

    Route::prefix('voucher')->group(function () {
        Route::get('/', [AdminVoucherController::class, 'index'])->name('admin.voucher');
        Route::post('/handleCrudVoucher', [AdminVoucherController::class, 'handleCrudVoucher'])->name('admin.voucher.handleCrudVoucher');
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.order');
        Route::post('/handleCrudOrder', [AdminOrderController::class, 'handleCrudOrder'])->name('admin.order.handleCrudOrder');
    });

    Route::prefix('request')->group(function () {
        Route::get('/unpaid', [AdminRequestController::class, 'unpaid'])->name('admin.request.unpaid');
        Route::get('/return', [AdminRequestController::class, 'return'])->name('admin.request.return');
        Route::post('/handleCrudRequest', [AdminRequestController::class, 'handleCrudRequest'])->name('admin.request.handleCrudRequest');
    });

    Route::prefix('history')->group(function () {
        Route::get('/operation', [AdminOperationHistoryController::class, 'index'])->name('admin.history.operation');
    });
});
