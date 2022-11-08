<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    protected $primaryKey = 'id_book';
    public $timestamps = true;

    protected $fillable = ['book_name', 'author', 'desc', 'image'];
    use HasFactory;
}
