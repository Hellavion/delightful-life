<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\SettingsComposer;

/**
 * Сервис-провайдер настроек сайта
 */
class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Регистрация сервисов
     */
    public function register(): void
    {
        //
    }

    /**
     * Загрузка сервисов
     */
    public function boot(): void
    {
        // Привязываем SettingsComposer ко всем представлениям
        View::composer('*', SettingsComposer::class);
    }
}
