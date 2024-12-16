<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Device;
use App\Services\FirebaseService;

class FirebaseNotificationJob implements ShouldQueue
{
    use Queueable;

    public $tries = 1;
    public $timeout = 600;

    /**
     * Create a new job instance.
     * @param Device $device - device that will receive notification
     * @param string $title - notification title
     * @param string $message - notification message
     * 
     */
    public function __construct(private Device $device, private string $title, private string $message){
        $this->onQueue('firebase');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new FirebaseService)->notify($this->device,$this->title,$this->message);
    }
}
