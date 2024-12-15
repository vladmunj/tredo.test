<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeviceService;

final class DeviceController extends Controller
{
    /**
     * Register new device
     * @param Request $request - user id, token
     * @return mixed - new device instance or existing one
     */
    public function register(Request $request) : mixed{
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'token' => 'required|string|max:255'
        ]);
        return (new DeviceService)->create($request);
    }
}
