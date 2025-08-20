<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

/**
 * Контроллер услуг
 */
class ServiceController extends Controller
{
    /**
     * Отображение списка услуг
     */
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('services.index', compact('services'));
    }

    /**
     * Отображение отдельной услуги
     */
    public function show(Service $service)
    {
        if (!$service->is_active) {
            abort(404);
        }

        return view('services.show', compact('service'));
    }
}
