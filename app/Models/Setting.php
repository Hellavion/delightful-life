<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель настроек сайта
 * 
 * @property int $id
 * @property string $key Ключ настройки
 * @property string $value Значение настройки
 * @property string $type Тип настройки (text, textarea, boolean, etc.)
 * @property string $group Группа настроек
 * @property string|null $description Описание настройки
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Setting extends Model
{
    /**
     * Массово присваиваемые атрибуты
     *
     * @var array<string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description'
    ];

    /**
     * Получить значение настройки по ключу
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return match($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $setting->value,
            'float' => (float) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value
        };
    }

    /**
     * Установить значение настройки
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string $group
     * @param string|null $description
     * @return static
     */
    public static function set(string $key, $value, string $type = 'text', string $group = 'general', ?string $description = null): static
    {
        $processedValue = match($type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => (string) $value
        };

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $processedValue,
                'type' => $type,
                'group' => $group,
                'description' => $description
            ]
        );
    }

    /**
     * Получить настройки по группе
     *
     * @param string $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByGroup(string $group)
    {
        return static::where('group', $group)->get();
    }
}
