<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionOrderItem extends Model
{
    use HasFactory;


    public function has_session(){
        return $this->hasOne(Session::class, 'id', 'session_id');
    }
}
