<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessRegistrationResource\Pages;
use App\Filament\Resources\BusinessRegistrationResource\RelationManagers;
use App\Models\BusinessRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BusinessRegistrationResource extends Resource
{
    protected static ?string $model = BusinessRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('business_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Business Name'),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Email'),

                Forms\Components\Select::make('package')
                    ->options([
                        'gold' => 'Gold',
                        'diamond' => 'Diamond',
                        'silver' => 'Silver',
                        'bronze' => 'Bronze',
                    ])
                    ->required()
                    ->label('Package'),

                    // message
                Forms\Components\Textarea::make('message'),

                Forms\Components\DateTimePicker::make('created_at')
                    ->default(now())
                    ->required()
                    ->label('Created At'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business_name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('package')
                    ->formatStateUsing(function (string $state) { // FIX HERE
                        return match ($state) {
                            'gold' => 'Gold',
                            'diamond' => 'Diamond',
                            'silver' => 'Silver',
                            'bronze' => 'Bronze',
                            default => $state,
                        };
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('package')
                    ->options([
                        'gold' => 'Gold',
                        'diamond' => 'Diamond',
                        'silver' => 'Silver',
                        'bronze' => 'Bronze',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBusinessRegistrations::route('/'),
            'create' => Pages\CreateBusinessRegistration::route('/create'),
            'edit' => Pages\EditBusinessRegistration::route('/{record}/edit'),
        ];
    }
}
