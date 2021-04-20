<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['isbn', 'book_title', 'cover_url'];

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function getRouteKeyName()
    {
        return 'isbn';
    }
}
