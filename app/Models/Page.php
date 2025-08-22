<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель статичной страницы
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $template
 * @property bool $is_published
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int $sort_order
 */
class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'template',
        'is_published',
        'seo_title',
        'seo_description',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Scope для опубликованных страниц
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
