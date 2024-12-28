<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;


    public function has_packages(){
        return $this->hasMany(Package::class, 'session_id','id');
    }
}
