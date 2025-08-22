<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

/**
 * Контроллер для административного управления заказами
 */
class OrderController extends Controller
{
    /**
     * Отображение списка заказов
     */
    public function index(Request $request): View
    {
        $query = Order::with('service')
            ->orderBy('created_at', 'desc');

        // Фильтрация по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Поиск по номеру заказа или имени клиента
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('client_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20);
        $statuses = Order::getStatuses();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Отображение формы создания нового заказа
     */
    public function create(): View
    {
        $services = Service::where('is_active', true)->get();
        $statuses = Order::getStatuses();

        return view('admin.orders.create', compact('services', 'statuses'));
    }

    /**
     * Сохранение нового заказа
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'description' => 'required|string',
            'requirements' => 'nullable|array',
            'dimensions' => 'nullable|string|max:255',
            'deadline' => 'nullable|date|after:today',
            'price' => 'required|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'deposit_paid' => 'boolean',
            'full_payment_received' => 'boolean',
            'status' => ['required', Rule::in(array_keys(Order::getStatuses()))],
            'notes' => 'nullable|string',
        ]);

        // Генерация номера заказа
        $validated['order_number'] = $this->generateOrderNumber();

        $order = Order::create($validated);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Заказ успешно создан');
    }

    /**
     * Отображение детальной информации о заказе
     */
    public function show(Order $order): View
    {
        $order->load('service');
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Отображение формы редактирования заказа
     */
    public function edit(Order $order): View
    {
        $services = Service::where('is_active', true)->get();
        $statuses = Order::getStatuses();

        return view('admin.orders.edit', compact('order', 'services', 'statuses'));
    }

    /**
     * Обновление заказа
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'description' => 'required|string',
            'requirements' => 'nullable|array',
            'dimensions' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'deposit_paid' => 'boolean',
            'full_payment_received' => 'boolean',
            'status' => ['required', Rule::in(array_keys(Order::getStatuses()))],
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Заказ успешно обновлен');
    }

    /**
     * Удаление заказа
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Заказ успешно удален');
    }

    /**
     * Изменение статуса заказа
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::getStatuses()))],
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Статус заказа обновлен');
    }

    /**
     * Отметка оплаты депозита
     */
    public function markDepositPaid(Order $order): RedirectResponse
    {
        $order->update(['deposit_paid' => true]);

        return redirect()
            ->back()
            ->with('success', 'Депозит помечен как оплаченный');
    }

    /**
     * Отметка полной оплаты
     */
    public function markFullyPaid(Order $order): RedirectResponse
    {
        $order->update([
            'full_payment_received' => true,
            'deposit_paid' => true
        ]);

        return redirect()
            ->back()
            ->with('success', 'Заказ помечен как полностью оплаченный');
    }

    /**
     * Генерация уникального номера заказа
     */
    private function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
