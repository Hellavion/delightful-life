<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Контроллер контактов
 */
class ContactController extends Controller
{
    /**
     * Отображение контактной страницы
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Обработка отправки контактной формы
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => ['required', Rule::in(array_keys(Contact::getTypes()))],
        ]);

        Contact::create($validated);

        return redirect()->route('contact.index')
            ->with('success', 'Ваше сообщение успешно отправлено!');
    }
}
