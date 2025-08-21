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
 * @property string $technique
 * @property int $year
 * @property float|null $width
 * @property float|null $height
 * @property float|null $price
 * @property bool $is_featured
 * @property bool $is_available
 * @property string|null $image_path
 */
class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'technique',
        'year',
        'width',
        'height',
        'price',
        'is_featured',
        'is_available',
        'image_path',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_available' => 'boolean',
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
