<?php

namespace App\Filament\Resources\FirebaseNotificationResource\Pages;

use App\Filament\Resources\FirebaseNotificationResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Notifications\Notification;
use App\Models\Device;
use App\Jobs\FirebaseNotificationJob;
use Carbon\Carbon;

class FirebaseNotificationSend extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = FirebaseNotificationResource::class;

    protected static string $view = 'filament.resources.firebase-notification-resource.pages.firebase-notification-send';

    public $header,$message,$notify_date_time;

    protected $rules = [
        'header' => 'required|string|max:255',
        'message' => 'required|string|max:255',
        'notify_date_time' => 'required|datetime'
    ];

    protected function getFormSchema() : array{
        return [
            Forms\Components\TextInput::make('header')->label('Title')->required()->maxLength(255),
            Forms\Components\Textarea::make('message')->label('Body')->required()->maxLength(255),
            Forms\Components\DateTimePicker::make('notify_date_time')->label('Notification date/time')->required()->format('Y-m-d H:i')->seconds(false)
        ];
    }

    public function submit(){
        $this->validate();

        # Dispatching jobs for all registered devices with user setting delay (notify date time value)
        Device::all()->map(function($device){
            FirebaseNotificationJob::dispatch($device,$this->header,$this->message)
                ->delay(Carbon::createFromFormat('Y-m-d\TH:i',$this->notify_date_time));
        });

        Notification::make()->title(__('filament.firebase.notification.alert.success'))->success()->send();
    }
}
