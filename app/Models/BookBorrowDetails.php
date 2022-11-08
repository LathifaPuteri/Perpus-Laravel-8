<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrowDetails extends Model
{
    protected $table = 'book_borrow_details';
    protected $primaryKey = 'id_book_borrow_detail';
    public $timestamps = true;

    protected $fillable = ['id_book_borrow', 'id_book', 'qty'];
    use HasFactory;

    public function book(){
        return $this->belongsTo('App\Models\Book','id_book','id_book');
    }
}
