<?php

use App\Http\Controllers\CarHistoryController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GarageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketPlaceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MotAppointmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecoveryController;
use App\Http\Controllers\RepairAppointmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SelectGarageController;
use App\Http\Controllers\ServiceAppointmentController;
use App\Http\Controllers\SupportController;
use App\Http\Livewire\CarTransfer;
use App\Http\Livewire\Notification;
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

// always redirect to login
Route::redirect('/', 'login');

// ['verify' => true]
Auth::routes();

// use PDF;

// Route::get('print', function () {
//     $car = CarInfo::find(1);
//     $car->load(['user', 'mots' => fn ($q) => $q->with('mot_task')->latest('datetime'), 'services' => fn ($q) => $q->with('tasks')->latest('datetime'), 'repairs' => fn ($q) => $q->with('tasks')->whereNotNull('datetime')->latest('datetime')]);
//     dd($car);

//     $pdf = PDF::loadView('garage.print', compact('car'));
//     return $pdf->download('history.pdf');
//     return view('garage.print', compact('car'));
// });

// , 'verified'
Route::middleware(['auth'])->group(function () {

    Route::get('language/set/{lang}', [HomeController::class, 'language'])->name('lang');
    Route::resource('garages', SelectGarageController::class)->only(['index', 'store', 'show', 'update']);

    // check weather user has selected garage
    Route::group(['middleware' => 'has_garage'], function () {

        Route::get('selected', [SelectGarageController::class, 'selected'])->name('selected');
        Route::get('review-garage', [SelectGarageController::class, 'review'])->name('garage.review');
        Route::post('garage/report', [SelectGarageController::class, 'report'])->name('garage.report');

        // garage routes
        Route::resource('garage', GarageController::class);

        Route::group(['middleware' => 'has_car'], function () {
            Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

            // membership routes
            Route::resource('memberships', MembershipController::class)->only(['index', 'show', 'store']);

            // payment routes
            Route::get('{payment_for?}/{id}/payment', [PaymentController::class, 'payment'])->name('payment');
            Route::post('payment/capture', [PaymentController::class, 'capture_payment'])->name('capture_payment');
            Route::post('payment', [PaymentController::class, 'save'])->name('payment.save');
            Route::post('promo/apply', [PaymentController::class, 'promocode'])->name('promo.apply');

            // mot appointments routes
            Route::get('mots/status', [MotAppointmentController::class, 'status'])->name('mots.status');
            Route::get('mots/{mot}/success', [MotAppointmentController::class, 'success'])->name('mots.success');
            Route::resource('mots', MotAppointmentController::class);

            // service appointments routes
            Route::get('services/{service}/success', [ServiceAppointmentController::class, 'success'])->name('services.success');
            Route::get('services/information', [ServiceAppointmentController::class, 'information'])->name('services.information');
            Route::resource('services', ServiceAppointmentController::class);

            // repair appointments routes
            Route::resource('repairs', RepairAppointmentController::class);

            // recoveries appointments routes
            Route::post('recoveries/{recovery}/quotes', [RecoveryController::class, 'select_quote'])->name('recoveries.quotes');
            Route::post('recoveries/{recovery}/complete', [RecoveryController::class, 'complete'])->name('recoveries.complete');
            Route::resource('recoveries', RecoveryController::class);

            // car transfer routes
            Route::get('car-transfer/{car}', CarTransfer::class)->name('car.transfer');

            // car transfer routes
            Route::get('car-history/{id}', [CarHistoryController::class, 'create'])->name('car.history');
            Route::get('car-history/{history}/download', [CarHistoryController::class, 'download'])->name('car.history.download');

            // notifications routes
            Route::get('notifications', Notification::class)->name('notification');

            // communities routes
            Route::resource('communities', CommunityController::class);

            // market place routes
            Route::group(['prefix' => 'marketplace', 'as' => 'marketplace.'], function () {
                // myplace route
                Route::get('my-place', [MarketPlaceController::class, 'myplace'])->name('myplace');
                // maerket place specific routes
                Route::get('/', [MarketPlaceController::class, 'index'])->name('index');
                Route::get('/create', [MarketPlaceController::class, 'create'])->name('create');
                Route::post('/store', [MarketPlaceController::class, 'store'])->name('store');
                Route::get('/{market}', [MarketPlaceController::class, 'show'])->name('show');
                Route::get('/{market}/edit', [MarketPlaceController::class, 'edit'])->name('edit');
                Route::put('/{market}/update', [MarketPlaceController::class, 'update'])->name('update');
                Route::get('details/{type}', [MarketPlaceController::class, 'details'])->name('details');
                Route::post('/buy', [MarketPlaceController::class, 'buy'])->name('buy');
                Route::post('/{market}/sold', [MarketPlaceController::class, 'sold'])->name('sold');
            });

            // reviews routes
            Route::resource('reviews', ReviewController::class);

            // supports tickets route
            Route::resource('supports', SupportController::class)->only(['index', 'create', 'show']);

            // feedback
            Route::resource('feedback', FeedbackController::class)->only(['index', 'store']);

            // account routes
            Route::get('my-account', [HomeController::class, 'account'])->name('account');
            Route::post('my-account', [HomeController::class, 'updateAccount'])->name('account.update');
        });
    });
});
