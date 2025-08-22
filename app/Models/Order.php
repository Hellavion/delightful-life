<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Spatie\MediaLibrary\HasMedia;
// use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Модель заказа
 *
 * @property int $id
 * @property string $order_number
 * @property int $service_id
 * @property string $client_name
 * @property string $client_email
 * @property string|null $client_phone
 * @property string $description
 * @property array|null $requirements
 * @property string|null $dimensions
 * @property \Carbon\Carbon|null $deadline
 * @property float $price
 * @property float|null $deposit
 * @property bool $deposit_paid
 * @property bool $full_payment_received
 * @property string $status
 * @property string|null $notes
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'service_id',
        'client_name',
        'client_email',
        'client_phone',
        'description',
        'requirements',
        'dimensions',
        'deadline',
        'price',
        'deposit',
        'deposit_paid',
        'full_payment_received',
        'status',
        'notes',
    ];

    protected $casts = [
        'requirements' => 'array',
        'deadline' => 'date',
        'price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'deposit_paid' => 'boolean',
        'full_payment_received' => 'boolean',
    ];

    /**
     * Связь с услугой
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Получить статусы заказов
     */
    public static function getStatuses(): array
    {
        return [
            'pending' => 'Ожидает подтверждения',
            'confirmed' => 'Подтвержден',
            'in_progress' => 'В работе',
            'review' => 'На согласовании',
            'completed' => 'Завершен',
            'cancelled' => 'Отменен',
        ];
    }
}
