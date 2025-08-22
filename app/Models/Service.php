<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Spatie\MediaLibrary\HasMedia;
// use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Модель услуги
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string|null $process_description
 * @property float|null $price_from
 * @property float|null $price_to
 * @property string $pricing_type
 * @property string|null $duration
 * @property array|null $features
 * @property bool $is_active
 * @property int $sort_order
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'process_description',
        'price_from',
        'price_to',
        'pricing_type',
        'duration',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price_from' => 'decimal:2',
        'price_to' => 'decimal:2',
    ];

    /**
     * Связь с заказами
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
