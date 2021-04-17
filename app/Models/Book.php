<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['book_title', 'cover_url', 'author_id'];

    public function author() {
        return $this->belongsTo(Author::class);
    }
}
