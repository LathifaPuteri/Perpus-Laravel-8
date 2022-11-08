<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';
    public $timestamps = true;
    public $primaryKey = 'id_student';

    protected $fillable = ['student_name', 'date_of_birth', 'gender', 'address', 'id_class', 'image'];
    use HasFactory;

    public function class(){
        return $this->belongsTo('App\Models\Grade','id_class','id_class');
    }
}
