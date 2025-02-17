<?php

namespace App\Filament\Resources\SponsoredAdResource\Pages;

use App\Filament\Resources\SponsoredAdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSponsoredAds extends ListRecords
{
    protected static string $resource = SponsoredAdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
