<?php

use App\Livewire\Catalog;
use App\Livewire\Home;
use App\Livewire\ShowProduct;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', Home::class)->name('home');
Route::get('/catalog', Catalog::class)->name('catalog');
Route::get('/', Catalog::class)->name('catalog');
Route::get('/show-product/{id}', ShowProduct::class)->name('show-product');

Route::get('/optimize', function(Request $request){
    Artisan::call('optimize:clear');
    echo "optimize ok";
});

Route::get('/link', function(Request $request){
    Artisan::call('storage:link');
    echo "link ok";
});

Route::get('/key', function(Request $request){
    Artisan::call('key:generate');
    echo "key ok";
});

Route::get('/cache', function(Request $request){
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('permission:cache-reset');
    echo "cache clear ok";
});

Route::get('/migrate-fresh', function(Request $request){
    Artisan::call('migrate:fresh --force --seed');
    echo "migrate fresh --force --seed ok";
});

Route::get('/migrate', function(Request $request){
    Artisan::call('migrate --force');
    echo "migrate ok";
});

Route::get('/5mcron', function(Request $request){
    Artisan::call('queue:work --stop-when-empty');
    // Artisan::call('queue:listen --timeout=0');
    echo "ok";
});

Route::get('/5mcrontime0', function(Request $request){
    Artisan::call('queue:work --timeout=0 --tries=3');
    echo "ok";
 });

// Route::get('/5mcron', function(Request $request){
//     Artisan::call('queue:work --timeout=60 --tries=3 --max-jobs=10');
//     echo "ok";
//  });
