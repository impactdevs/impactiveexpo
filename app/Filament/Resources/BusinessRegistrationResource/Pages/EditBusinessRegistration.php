<?php

namespace App\Filament\Resources\BusinessRegistrationResource\Pages;

use App\Filament\Resources\BusinessRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessRegistration extends EditRecord
{
    protected static string $resource = BusinessRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
