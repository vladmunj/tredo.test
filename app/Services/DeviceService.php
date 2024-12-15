<?php namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Device;

final class DeviceService{
    /**
     * Register new device
     * @param Request $request - user id, token
     * @return mixed - new device instance or existing one
     */
    public function create(Request $request) : mixed{
        return Device::firstOrCreate([
            'user_id' => $request->user_id,
            'token' => $request->token
        ],[]);
    }
}