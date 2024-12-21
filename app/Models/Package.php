<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;


    public function sessions()
    {
        return $this->belongsTo(Session::class,'session_id');
    }
}
