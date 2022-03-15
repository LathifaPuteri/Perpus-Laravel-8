<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReturn extends Model
{
    protected $table = 'book_return';
    public $timestamps = true;

    protected $fillable = ['id_book_borrow', 'date_of_returning', 'fine'];
    use HasFactory;
}
