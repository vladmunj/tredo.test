<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['token','device_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
