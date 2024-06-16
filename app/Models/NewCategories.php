<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "user_id",
        "about",
        "slug",
        "image"
    ];

    protected static function booted(): void
    {
        static::creating(function (NewCategories $model) {
            $model->slug = self::generateUniqueSlug($model->name);
        });
    }

    protected function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function news()
    {
        return $this->hasMany(News::class, 'category_id', 'id');
    }
}
