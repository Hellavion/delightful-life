<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Портфолио
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{artwork:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

// Услуги
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

// Новости
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{post:slug}', [NewsController::class, 'show'])->name('news.show');

// Контакты
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Заказы
Route::get('/order', [OrderController::class, 'create'])->name('orders.create');
Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('orders.success');
Route::get('/order/status', [OrderController::class, 'status'])->name('orders.status');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

// Административные маршруты
Route::prefix('admin')->group(base_path('routes/admin.php'));
