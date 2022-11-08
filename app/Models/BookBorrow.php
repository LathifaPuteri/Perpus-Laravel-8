<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrow extends Model
{
    protected $table = 'book_borrow';
    protected $primaryKey = 'id_book_borrow'; //id
    public $timestamps = true;

    protected $fillable = ['id_student', 'date_of_borrowing','date_of_returning'];
    use HasFactory;

    public function student(){
        return $this->belongsTo('App\Models\Students','id_student','id_student');
    }
}
