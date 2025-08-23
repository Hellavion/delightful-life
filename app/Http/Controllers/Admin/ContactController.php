<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Контроллер для административного управления обращениями клиентов
 */
class ContactController extends Controller
{
    /**
     * Отображение списка обращений
     */
    public function index(Request $request): View
    {
        $query = Contact::orderBy('created_at', 'desc');

        // Фильтрация по типу обращения
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Фильтрация по статусу прочтения
        if ($request->filled('is_read')) {
            $query->where('is_read', $request->boolean('is_read'));
        }

        // Фильтрация по статусу ответа
        if ($request->filled('is_replied')) {
            $query->where('is_replied', $request->boolean('is_replied'));
        }

        // Поиск по имени или email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);
        $types = Contact::getTypes();

        // Статистика для дашборда
        $stats = [
            'total' => Contact::count(),
            'unread' => Contact::where('is_read', false)->count(),
            'unreplied' => Contact::where('is_replied', false)->count(),
            'today' => Contact::whereDate('created_at', today())->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'types', 'stats'));
    }

    /**
     * Отображение детальной информации об обращении
     */
    public function show(Contact $contact): View
    {
        // Помечаем обращение как прочитанное при просмотре
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Удаление обращения
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Обращение успешно удалено');
    }

    /**
     * Изменение статуса прочтения
     */
    public function toggleRead(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => !$contact->is_read]);

        $status = $contact->is_read ? 'прочитанным' : 'непрочитанным';

        return redirect()
            ->back()
            ->with('success', "Обращение помечено как {$status}");
    }

    /**
     * Изменение статуса ответа
     */
    public function toggleReplied(Contact $contact): RedirectResponse
    {
        $contact->update(['is_replied' => !$contact->is_replied]);

        $status = $contact->is_replied ? 'отвеченным' : 'неотвеченным';

        return redirect()
            ->back()
            ->with('success', "Обращение помечено как {$status}");
    }

    /**
     * Обновление заметок администратора
     */
    public function updateNotes(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $contact->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Заметки администратора обновлены');
    }

    /**
     * Массовые действия с обращениями
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', Rule::in(['mark_read', 'mark_unread', 'mark_replied', 'mark_unreplied', 'delete'])],
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
        ]);

        $contacts = Contact::whereIn('id', $validated['contacts']);

        switch ($validated['action']) {
            case 'mark_read':
                $contacts->update(['is_read' => true]);
                $message = 'Выбранные обращения помечены как прочитанные';
                break;
            case 'mark_unread':
                $contacts->update(['is_read' => false]);
                $message = 'Выбранные обращения помечены как непрочитанные';
                break;
            case 'mark_replied':
                $contacts->update(['is_replied' => true]);
                $message = 'Выбранные обращения помечены как отвеченные';
                break;
            case 'mark_unreplied':
                $contacts->update(['is_replied' => false]);
                $message = 'Выбранные обращения помечены как неотвеченные';
                break;
            case 'delete':
                $contacts->delete();
                $message = 'Выбранные обращения удалены';
                break;
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }

    /**
     * Создание заказа на основе обращения
     */
    public function createOrderFromContact(Contact $contact): RedirectResponse
    {
        // Помечаем обращение как обработанное
        $contact->update([
            'is_read' => true,
            'admin_notes' => ($contact->admin_notes ? $contact->admin_notes . "\n\n" : '') . 
                           'Создан заказ на основе этого обращения - ' . now()->format('d.m.Y H:i')
        ]);

        // Формируем данные для передачи в форму создания заказа
        $contactData = [
            'client_name' => $contact->name,
            'client_email' => $contact->email,
            'client_phone' => $contact->phone,
            'description' => "Заказ на основе обращения #{$contact->id}: {$contact->subject}\n\n{$contact->message}",
            'source_contact_id' => $contact->id,
        ];

        return redirect()
            ->route('admin.orders.create')
            ->with('contact_data', $contactData)
            ->with('success', 'Перенаправление на создание заказа. Данные клиента предзаполнены.');
    }
}