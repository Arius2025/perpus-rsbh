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
        'user_id',
    ];

    public function category_ref()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCoverUrlAttribute()
    {
        if (!empty($this->cover_image) && file_exists(public_path('uploads/books/' . $this->cover_image))) {
            return asset('uploads/books/' . $this->cover_image);
        }
        return asset('images/default-cover.svg');
    }

    public function getHasCustomCoverAttribute()
    {
        return !empty($this->cover_image) && file_exists(public_path('uploads/books/' . $this->cover_image));
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
