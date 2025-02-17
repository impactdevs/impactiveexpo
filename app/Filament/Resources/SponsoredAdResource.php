<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SponsoredAdResource\Pages;
use App\Models\SponsoredAd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;


class SponsoredAdResource extends Resource
{
    protected static ?string $model = SponsoredAd::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('business_name')
                    ->label('Business Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('poster_path')
                    ->label('Upload Poster')
                    ->image()
                    ->disk('public') // Define the disk if needed (or use default 'public')
                    ->directory('sponsored_ads') // Define the folder where images will be stored
                    ->required()
                    ->enableOpen()
                    ->enableDownload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('business_name')->limit(50),
                Tables\Columns\ImageColumn::make('poster_path')
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
            'index' => Pages\ListSponsoredAds::route('/'),
            'create' => Pages\CreateSponsoredAd::route('/create'),
            'edit' => Pages\EditSponsoredAd::route('/{record}/edit'),
        ];
    }
}
