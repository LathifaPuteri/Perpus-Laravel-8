<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grade';
    public $primaryKey = 'id_class';
    public $timestamps = true;

    protected $fillable = ['class_name', 'group'];
    use HasFactory;
}
