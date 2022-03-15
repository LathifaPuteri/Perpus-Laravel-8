<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrow extends Model
{
    protected $table = 'book_borrow';
    public $timestamps = true;

    protected $fillable = ['id_student', 'date_of_borrowing','date_of_returning'];
    use HasFactory;
}
