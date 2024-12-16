<?php

namespace App\Filament\Resources\FirebaseNotificationResource\Pages;

use App\Filament\Resources\FirebaseNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFirebaseNotification extends EditRecord
{
    protected static string $resource = FirebaseNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
