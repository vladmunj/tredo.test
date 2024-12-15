<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Str;
use App\Models\Device;

class DeviceRegisterTest extends TestCase
{
    /**
     * Register new device with random token.
     */
    public function test_new_device(): void
    {
        $response = $this->postJson('/api/device/register',['user_id' => 1,'token'=> Str::random(30)]);
        $response->assertCreated();
        $response->assertJson(fn(AssertableJson $json) =>
            $json->hasAll(['id','user_id','created_at','updated_at'])
        );
    }

    /**
     * Register new device with existing token.
     */
    public function test_new_device_with_same_token(){
        $device = Device::latest()->first();
        $response = $this->postJson('/api/device/register',['user_id' => $device->user_id,'token'=> $device->token]);
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) =>
            $json->hasAll(['id','user_id','created_at','updated_at'])
        );
    }
}
