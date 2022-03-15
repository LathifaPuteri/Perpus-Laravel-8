<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';
    public $timestamps = true;

    protected $fillable = ['student_name', 'date_of_birth', 'gender', 'address', 'id_class'];
    use HasFactory;
}
