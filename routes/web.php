<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExtractController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TransactionController;
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

Route::get('session', [SessionController::class, 'index'])->name('login');
Route::post('session', [SessionController::class, 'store'])->name('session.store');

Route::middleware(['auth', 'auth.session'])->group(function() {
    Route::get('session/edit', [SessionController::class, 'edit'])->name('session.edit');
    Route::patch('session', [SessionController::class, 'update'])->name('session.update');
    Route::delete('session', [SessionController::class, 'destroy'])->name('session.destroy');

    Route::get('/', DashboardController::class)->name('dashboard.index');

    Route::get('transactions/pending', [TransactionController::class, 'pending'])->name('transactions.pending');
    Route::get('transactions/grouped', [TransactionController::class, 'grouped'])->name('transactions.grouped');
    Route::patch('transactions/{transaction}/release', [TransactionController::class, 'release'])->name('transactions.release');
    Route::resource('transactions', TransactionController::class)->except([
        'show',
        'destroy',
    ]);
    Route::get('transactions/{group_id}', [TransactionController::class, 'show'])->name('transactions.show');

    Route::get('extracts', [ExtractController::class, 'index'])->name('extracts.index');
    Route::get('extracts/{segment}', [ExtractController::class, 'show'])->withTrashed()->name('extracts.show');

    Route::resource('segments', SegmentController::class)->except([
        'show',
        'destroy',
    ]);
    Route::delete('segments/{segment}', [SegmentController::class, 'destroy'])->withTrashed()->name('segments.destroy');
});
