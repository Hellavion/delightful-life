<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель контактной формы
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $subject
 * @property string $message
 * @property string $type
 * @property bool $is_read
 * @property bool $is_replied
 * @property string|null $admin_notes
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'type',
        'is_read',
        'is_replied',
        'admin_notes',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_replied' => 'boolean',
    ];

    /**
     * Получить типы обращений
     */
    public static function getTypes(): array
    {
        return [
            'general' => 'Общий вопрос',
            'order' => 'Заказ',
            'collaboration' => 'Сотрудничество',
        ];
    }

    /**
     * Scope для непрочитанных сообщений
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
