<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
 */

Route::group(["prefix" => "/"], function () {

    /*
    |--------------------------------------------------------------------------
    | Guest Routes
    |--------------------------------------------------------------------------
     */
    Route::middleware(["guest"])->group(function () {
        Route::get("", function () {
            return view('pages.welcome');
        })->name('home');

        Route::get('/product', function () {
            return view('pages.product');
        })->name('product');

        Route::get('/sertification', function () {
            return view('pages.sertification');
        })->name('sertification');

        Route::get('/about', function () {
            return view('pages.about');
        })->name('about');

        Route::post("/feedbacks", [LoginController::class, "feedback"])->name("feedbacks");
        Route::put("/reset-submission/{email}", [UserController::class, "resetSubmission"])->name("user.resetSubmission");
    });

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
     */

    Route::post('/login', [LoginController::class, "login"])->name('login');

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
     */

    Route::middleware(["user.authentication"])->group(function () {
        Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');
        Route::delete("/feedbacks/{id}", [LoginController::class, "feedbackDestroy"])->name("feedbacks.destroy");

        Route::prefix("stocks")->group(function () {
            Route::get('/', [StockController::class, 'index'])->name('stocks.index');
            Route::post('/', [StockController::class, 'store'])->name('stocks.store');
            Route::post('/export', [StockController::class, 'export'])->name('stocks.export');

            Route::put('/{id}', [StockController::class, 'update'])->name('stocks.update');
            Route::delete('/{id}', [StockController::class, 'destroy'])->name('stocks.destroy');
        });

        Route::prefix("company-assets")->group(function () {
            Route::get('/', [AssetController::class, 'index'])->name('assets.index');
            Route::post('/', [AssetController::class, 'store'])->name('assets.store');
            Route::post('/export', [AssetController::class, 'export'])->name('assets.export');
            Route::put('/{id}', [AssetController::class, 'update'])->name('assets.update');
            Route::delete('/{id}', [AssetController::class, 'destroy'])->name('assets.destroy');
        });

        Route::prefix("customers")->group(function () {
            Route::get("/", [CustomerController::class, "index"])->name('customer');
            Route::get("/{id}", [CustomerController::class, "show"])->name('customer.show');
            Route::post("/", [CustomerController::class, "store"])->name('customer.store');
            Route::post("/import", [CustomerController::class, "import"])->name('customer.import');
            Route::post("/export", [CustomerController::class, "export"])->name('customer.export');
            Route::put("/{id}", [CustomerController::class, "update"])->name('customer.update');
            Route::delete("/{id}", [CustomerController::class, "destroy"])->name('customer.destroy');
            Route::get("/template", [CustomerController::class, "template"])->name("customer.template");
        });

        Route::prefix("suppliers")->group(function () {
            Route::get("/", [SupplierController::class, "index"])->name('supplier');
            Route::post("/", [SupplierController::class, "store"])->name('supplier.store');
            Route::put("/{id}", [SupplierController::class, "update"])->name('supplier.update');
            Route::delete("/{id}", [SupplierController::class, "destroy"])->name('supplier.destroy');
        });

        Route::prefix("visits")->group(function () {
            Route::get("/", [VisitController::class, "index"])->name('visit');
            Route::post("/", [VisitController::class, "store"])->name('visit.store');
            Route::put("/{id}", [VisitController::class, "update"])->name('visit.update');
            Route::delete("/{id}", [VisitController::class, "destroy"])->name('visit.destroy');
        });

        Route::prefix("employees")->group(function () {
            Route::get("/", [EmployeeController::class, "index"])->name('employee');
            Route::post("/", [EmployeeController::class, "store"])->name('employee.store');
            Route::post("export", [EmployeeController::class, "export"])->name('employee.export');
            Route::put("/{id}", [EmployeeController::class, "update"])->name('employee.update');
            Route::delete("/{id}", [EmployeeController::class, "destroy"])->name('employee.destroy');
        });

        Route::prefix('purchase')->group(function () {
            Route::get("/", [PurchaseController::class, "index"])->name('purchase');

            Route::post("/", [PurchaseController::class, "store"])->name("purchase.store");
            Route::post("/export", [PurchaseController::class, "exportList"])->name("purchase.export");
            Route::put("/{id}", [PurchaseController::class, "update"])->name("purchase.update");
            Route::delete("/{id}", [PurchaseController::class, "destroy"])->name("purchase.destroy");
            Route::patch("/{id}", [PurchaseController::class, "submit"])->name("purchase.submission");
            Route::patch("/pay/{id}", [PurchaseController::class, "pay"])->name("purchase.pay");
            Route::put("/approve/{id}", [PurchaseController::class, "approve"])->name("purchase.approve");
            Route::put("/reject/{id}", [PurchaseController::class, "reject"])->name("purchase.reject");
        });
        Route::prefix("history-purchase")->group(function () {
            Route::get("/", [PurchaseController::class, "history"])->name("purchaseHistory");
            Route::post("/export", [PurchaseController::class, "export"])->name("purchaseHistory.export");
        });
        Route::prefix("history-sales")->group(function () {
            Route::get("/", [SalesController::class, "history"])->name("salesHistory");
            Route::post("/export", [SalesController::class, "export"])->name("salesHistory.export");
        });

        Route::prefix("debts")->group(function () {
            Route::get("/payable", [DebtController::class, "indexHutang"])->name("debts.payable");
            Route::get("/receivable", [DebtController::class, "indexPiutang"])->name("debts.receivable");
            Route::post("/payable/export", [DebtController::class, "exportHutang"])->name("debts.payable.export");
            Route::post("/receivable/export", [DebtController::class, "exportPiutang"])->name("debts.receivable.export");
        });

        Route::prefix("sales")->group(function () {
            Route::get("/", [SalesController::class, "index"])->name("sales");
            Route::post("/", [SalesController::class, "store"])->name("sales.store");
            Route::post("/export", [SalesController::class, "exportList"])->name("sales.export");
            Route::put("/{id}", [SalesController::class, "update"])->name("sales.update");
            Route::delete("/{id}", [SalesController::class, "destroy"])->name("sales.destroy");
            Route::patch("/{id}", [SalesController::class, "submit"])->name("sales.submission");
            Route::patch("/pay/{id}", [SalesController::class, "pay"])->name("sales.pay");
            Route::put("/approve/{id}", [SalesController::class, "approve"])->name("sales.approve");
            Route::put("/reject/{id}", [SalesController::class, "reject"])->name("sales.reject");
        });

        Route::prefix("finance")->group(function () {
            Route::get("/", [FinanceController::class, "index"])->name("finance");
            Route::post("/", [FinanceController::class, "store"])->name("finance.store");
            Route::post("/export", [FinanceController::class, "export"])->name("finance.export");
            Route::put("/{id}", [FinanceController::class, "update"])->name("finance.update");
            Route::delete("/{id}", [FinanceController::class, "destroy"])->name("finance.destroy");
        });

        Route::prefix("feedbacks")->group(function () {
            Route::get("/", [LoginController::class, "feedbackIndex"])->name("feedbacks");
        });

        Route::prefix("delivery")->group(function () {
            Route::get("/", [ShipmentController::class, "index"])->name("delivery");
            Route::post("/export", [ShipmentController::class, "export"])->name("delivery.export");
            Route::put("/shipping/{id}", [ShipmentController::class, "delivery"])->name("delivery.shipping");
            Route::put("/done/{id}", [ShipmentController::class, "done"])->name("delivery.done");
        });

        Route::prefix("visit")->group(function () {
            Route::get("/", [VisitController::class, "index"])->name("visit");
            Route::post("/", [VisitController::class, "store"])->name("visit.store");
            Route::post("/export", [VisitController::class, "export"])->name("visit.export");
            Route::put("/{id}", [VisitController::class, "update"])->name("visit.update");
            Route::delete("/{id}", [VisitController::class, "destroy"])->name("visit.destroy");
        });

        Route::prefix("history-delivery")->group(function () {
            Route::get("/", [ShipmentController::class, "history"])->name("deliveryHistory");
            Route::post("/export", [ShipmentController::class, "export"])->name("deliveryHistory.export");
        });

        Route::prefix('profile')->group(function () {
            Route::get("/", [ProfileController::class, "index"])->name('profile');
            Route::put("/{id}", [ProfileController::class, "update"])->name('profile.update');
        });

        Route::prefix("media")->group(function () {
            Route::get("/", [MediaController::class, "index"])->name("media.index");
            Route::post("/", [MediaController::class, "store"])->name("media.store");
            Route::put("/{id}", [MediaController::class, "update"])->name("media.update");
            Route::delete("/{id}", [MediaController::class, "destroy"])->name("media.destroy");
        });

        Route::prefix("user")->group(function () {
            Route::get("/", [UserController::class, "index"])->name("user");
            Route::put("/reset-password/{id}", [UserController::class, "resetPassword"])->name("user.resetPassword");
        });

        Route::delete("/logout", [LoginController::class, "logout"])->name('logout');
    });

});