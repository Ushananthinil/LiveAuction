<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BidController;

use App\Http\Controllers\AuctionController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/bids', [BidController::class, 'index'])->name('bids.index');
});


Route::middleware(['auth', 'role:bidder'])->group(function () {
    Route::get('/auction/{product}', [AuctionController::class, 'show'])->name('auction.show');
    Route::post('/bid/{product}', [BidController::class, 'store'])->name('bids.store');
    Route::get('/my-bids', [\App\Http\Controllers\Bidder\MyBidsController::class, 'index'])->name('mybids');
});





require __DIR__.'/auth.php';
