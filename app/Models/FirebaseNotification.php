<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirebaseNotification extends Model
{
    protected $fillable = ['device_id','title','message','status','http_response'];

    protected $casts = [
        'http_response' => 'array'
    ];

    public function device(){
        return $this->belongsTo(Device::class,'device_id','id');
    }
}
