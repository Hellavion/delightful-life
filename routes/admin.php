<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ArtworkController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Маршруты для административной панели
|
*/

// Маршруты аутентификации администратора
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

Route::middleware('admin')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    // Главная страница админки
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Управление портфолио
    Route::resource('artworks', ArtworkController::class, ['as' => 'admin']);
    
    // Дополнительные маршруты для произведений
    Route::patch('/artworks/{artwork}/toggle-featured', [ArtworkController::class, 'toggleFeatured'])->name('admin.artworks.toggle-featured');
    Route::patch('/artworks/{artwork}/toggle-availability', [ArtworkController::class, 'toggleAvailability'])->name('admin.artworks.toggle-availability');

    // Управление услугами
    Route::resource('services', ServiceController::class, ['as' => 'admin']);
    
    // Дополнительные маршруты для услуг
    Route::patch('/services/{service}/toggle-active', [ServiceController::class, 'toggleActive'])->name('admin.services.toggle-active');
    Route::post('/services/update-order', [ServiceController::class, 'updateOrder'])->name('admin.services.update-order');
});