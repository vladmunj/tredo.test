<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;

Route::group(['prefix' => 'device'], function(){
    Route::post('register',[DeviceController::class,'register']);
});