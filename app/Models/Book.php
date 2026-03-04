<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'description',
        'category', // keeping for legacy migration, will remove later or keep for safety
        'category_id',
        'cover_image',
        'pdf_file',
        'external_link',
        'download_count',
        'is_active',
    ];

    public function category_ref()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static $categories = [
        'Teknologi',
        'Sains',
        'Sastra',
        'Pendidikan',
        'Bisnis',
        'Kesehatan',
        'Sejarah',
        'Agama',
        'Komik',
        'Hukum',
        'Novel',
        'Lainnya'
    ];
}
