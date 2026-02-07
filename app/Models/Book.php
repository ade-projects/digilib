<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category_id',
        'stock',
        'isbn',
        'pages',
        'language',
        'description',
        'cover_image',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
