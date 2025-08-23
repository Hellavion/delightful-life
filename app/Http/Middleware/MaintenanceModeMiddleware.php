<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware для проверки режима технических работ
 */
class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем включен ли режим технических работ
        $maintenanceMode = setting('site_maintenance', false);
        
        if ($maintenanceMode) {
            // Исключения для админки и служебных маршрутов
            if ($request->is('admin') || 
                $request->is('admin/*') || 
                $request->is('livewire/*') || 
                $request->is('_ignition/*') ||
                $request->is('up') ||
                $request->is('login') ||
                $request->is('logout') ||
                $request->is('register') ||
                $request->is('password/*') ||
                $request->is('forgot-password') ||
                $request->is('reset-password') ||
                $request->is('verify-email') ||
                $request->is('dashboard') ||
                $request->is('settings') ||
                $request->is('settings/*') ||
                $request->is('flux/*') ||
                $request->is('fonts/*')) {
                return $next($request);
            }
            
            // Показываем страницу технических работ
            return response()->view('maintenance', [
                'site_name' => setting('site_name', 'Сайт'),
                'artist_name' => setting('artist_name', 'Художник'),
                'contact_email' => setting('contact_email', ''),
            ], 503);
        }

        return $next($request);
    }
}
