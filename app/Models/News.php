<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'text',
        'store_date',
        'slug',
        'video',
        'thumbnail'
    ];

    protected static function booted(): void
    {
        static::creating(function (News $model) {
            $model->slug = self::generateUniqueSlug($model->title);
        });
    }

    public function categories()
    {
        return $this->belongsTo(NewCategories::class, 'category_id');
    }

    public static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
    
    
}
