<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('web.index');
})->name('home');

// Language Switcher
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');


Route::view('findTicket', 'web.tickets.check')->name('findTicketView');

Route::post('findTicket', [\App\Http\Controllers\Web\TicketController::class, 'findTicket'])->name('findTicket');
// details
Route::get('tickets/review', [\App\Http\Controllers\Web\TicketController::class, 'review'])->name('tickets.review');
Route::post('tickets/review', [\App\Http\Controllers\Web\TicketController::class, 'storeReview'])->name('tickets.review.store');
Route::resource('tickets', \App\Http\Controllers\Web\TicketController::class)->except('delete', 'index');
Route::get('buildingsByCity/{city}', [\App\Http\Controllers\Web\BuildingController::class, 'buildingsByCity']);
Route::get('ticket/close/{ticket}', [\App\Http\Controllers\Web\TicketController::class, 'closeTicket'])->name('ticket.close');
Route::get('details/{ticket}', [\App\Http\Controllers\Web\TicketController::class, 'details'])->name('ticket.details');



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'dashboard'], function () {
    Auth::routes(['register' => false]);
    Route::middleware(['auth'])->name('dashboard.')->group(function () {

        Route::middleware(['role:super-admin|admin'])->group(function () {

            Route::resource('users', UserController::class)->except('show');

            Route::get('tickets/trash', [TicketController::class, 'trash'])->name('tickets.trash');
            Route::delete('tickets/trash/{id}/force-delete', [TicketController::class, 'forceDelete'])->name('tickets.forceDelete');
            Route::get('tickets/trash/{id}/restore', [TicketController::class, 'restore'])->name('tickets.restore');
            Route::post('ticket/assign', [TicketController::class, 'assign'])->name('tickets.assign');
        });

        Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('isUser');
        Route::get('/reset-filters', [TicketController::class, 'resetFilters'])->name('tickets.reset-filters');
        Route::post('/generate-pdf/{ticket}', [TicketController::class, 'generateAndSavePdf'])->name('tickets.generate-pdf');
        Route::post('tickets/pdf', [TicketController::class, 'generateAndSavePdf'])->name('tickets.generateAllPdf');


        Route::get('tickets/support', [TicketController::class, 'supportIndex'])->name('tickets.support');
        Route::get('tickets/{ticket}/review', [TicketController::class, 'getReview'])->name('tickets.getReview');
        Route::post('tickets/report', [TicketController::class, 'report'])->name('tickets.report');
        Route::post('tickets/closeTicket', [TicketController::class, 'closeTicket'])->name('tickets.closeTicket');
        Route::post('tickets/send-close-otp', [TicketController::class, 'sendCloseOtp'])->name('tickets.sendCloseOtp');
        Route::post('/send-close-ticket-code', [TicketController::class, 'sendTicketCloseCodeSms'])->name('tickets.sendTicketCloseCodeSms');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::resource('tickets', TicketController::class);
    });
});
