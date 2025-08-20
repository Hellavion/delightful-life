<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Spatie\MediaLibrary\HasMedia;
// use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Модель произведения искусства
 * 
 * @property int $id
 * @property string $title
 * @property string|null $description  
 * @property string $slug
 * @property string|null $medium
 * @property string|null $dimensions
 * @property int|null $year_created
 * @property float|null $price
 * @property bool $is_featured
 * @property bool $is_sold
 * @property bool $is_available_for_print
 * @property array|null $tags
 * @property int $sort_order
 */
class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'medium',
        'dimensions',
        'year_created',
        'price',
        'is_featured',
        'is_sold',
        'is_available_for_print',
        'tags',
        'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_sold' => 'boolean',
        'is_available_for_print' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Связь с категориями
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
