<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FirebaseNotificationResource\Pages;
use App\Filament\Resources\FirebaseNotificationResource\RelationManagers;
use App\Models\FirebaseNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class FirebaseNotificationResource extends Resource
{
    protected static ?string $model = FirebaseNotification::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#'),
                TextColumn::make('device.token')->label('Device token'),
                TextColumn::make('status')->label('Status'),
                TextColumn::make('http_response')->label('Http response')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('send-notification')->label('Send notification')->button()->url(fn(): string => route('filament.admin.resources.firebase-notifications.notify'))
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFirebaseNotifications::route('/'),
            'create' => Pages\CreateFirebaseNotification::route('/create'),
            'edit' => Pages\EditFirebaseNotification::route('/{record}/edit'),
            'notify' => Pages\FirebaseNotificationSend::route('/notify')
        ];
    }
}
