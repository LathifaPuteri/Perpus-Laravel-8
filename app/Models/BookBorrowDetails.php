<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrowDetails extends Model
{
    protected $table = 'book_borrow_details';
    public $timestamps = true;

    protected $fillable = ['id_book_borrow', 'id_book', 'qty'];
    use HasFactory;
}
