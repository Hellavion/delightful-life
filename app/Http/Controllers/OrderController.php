<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Контроллер для публичного создания заказов
 */
class OrderController extends Controller
{
    /**
     * Отображение формы создания заказа
     */
    public function create(Request $request): View
    {
        $services = Service::where('is_active', true)->get();
        $selectedService = null;

        // Если передан ID услуги
        if ($request->filled('service')) {
            $selectedService = Service::where('is_active', true)
                ->find($request->service);
        }

        return view('orders.create', compact('services', 'selectedService'));
    }

    /**
     * Сохранение нового заказа от клиента
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'description' => 'required|string|min:10',
            'requirements' => 'nullable|array',
            'dimensions' => 'nullable|string|max:255',
            'deadline' => 'nullable|date|after:today',
        ]);

        // Получаем базовую цену услуги
        $service = Service::findOrFail($validated['service_id']);
        $validated['price'] = $service->price_from ?? 0;

        // Автоматические значения для публичного заказа
        $validated['order_number'] = $this->generateOrderNumber();
        $validated['status'] = 'pending';
        $validated['deposit_paid'] = false;
        $validated['full_payment_received'] = false;

        // Устанавливаем депозит в 30% от базовой цены (если цена указана)
        if ($service->price_from > 0) {
            $validated['deposit'] = $service->price_from * 0.3;
        }

        $order = Order::create($validated);

        // Здесь можно добавить отправку email уведомлений

        return redirect()
            ->route('orders.success', $order)
            ->with('success', 'Ваш заказ успешно отправлен! Мы свяжемся с вами в ближайшее время.');
    }

    /**
     * Страница успешного оформления заказа
     */
    public function success(Order $order): View
    {
        return view('orders.success', compact('order'));
    }

    /**
     * Отображение статуса заказа по номеру
     */
    public function status(Request $request): View
    {
        $order = null;
        $errorMessage = null;

        if ($request->filled('order_number')) {
            $order = Order::where('order_number', $request->order_number)
                ->with('service')
                ->first();

            if (! $order) {
                $errorMessage = 'Заказ с таким номером не найден';
            }
        }

        return view('orders.status', compact('order', 'errorMessage'));
    }

    /**
     * Генерация уникального номера заказа
     */
    private function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-'.date('Y').'-'.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
