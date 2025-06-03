<?php

namespace App\Filament\Resources\BusinessRegistrationResource\Pages;

use App\Filament\Resources\BusinessRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBusinessRegistrations extends ListRecords
{
    protected static string $resource = BusinessRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
