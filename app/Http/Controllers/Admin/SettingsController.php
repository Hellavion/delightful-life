<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

/**
 * Контроллер для управления настройками сайта
 */
class SettingsController extends Controller
{
    /**
     * Отображение формы настроек
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settingsByGroup = Setting::all()->groupBy('group');
        
        // Группы настроек с их человеко-читаемыми названиями
        $groups = [
            'general' => 'Общие настройки',
            'contact' => 'Контактная информация',
            'social' => 'Социальные сети',
            'seo' => 'SEO настройки',
            'portfolio' => 'Портфолио',
            'services' => 'Услуги'
        ];

        return view('admin.settings.index', compact('settingsByGroup', 'groups'));
    }

    /**
     * Обновление настроек
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string'
        ]);

        // Получаем все настройки типа boolean для обработки unchecked состояния
        $booleanSettings = Setting::where('type', 'boolean')->get();
        
        // Сначала сбрасываем все boolean поля в 0 (unchecked)
        foreach ($booleanSettings as $booleanSetting) {
            $booleanSetting->update(['value' => '0']);
        }

        // Затем обрабатываем отправленные данные
        foreach ($validated['settings'] as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                // Обработка значения в зависимости от типа
                $processedValue = $this->processValue($value, $setting->type);
                $setting->update(['value' => $processedValue]);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Настройки успешно обновлены');
    }

    /**
     * Обработка значения в зависимости от типа настройки
     *
     * @param mixed $value
     * @param string $type
     * @return string
     */
    private function processValue($value, string $type): string
    {
        return match($type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => (string) $value
        };
    }
}
