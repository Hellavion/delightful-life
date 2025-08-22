<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Spatie\MediaLibrary\HasMedia;
// use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Модель новости
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $content
 * @property string|null $featured_image
 * @property bool $is_published
 * @property bool $is_featured
 * @property array|null $tags
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property \Carbon\Carbon|null $published_at
 */
class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'is_published',
        'is_featured',
        'tags',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Scope для опубликованных новостей
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope для рекомендуемых новостей
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
