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
                    
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(20)
                    ->label('Phone'),

                // Sponsor Package
                Forms\Components\Select::make('sponsor_package')
                    ->options([
                        'platinum' => 'Platinum - 100m',
                        'diamond' => 'Diamond - 50m',
                        'gold' => 'Gold - 25m',
                        'silver' => 'Silver - 10m',
                        'bronze' => 'Bronze - 5m',
                    ])
                    ->nullable()
                    ->label('Sponsor Package'),
                    
                // Exhibitor Package
                Forms\Components\Select::make('exhibitor_package')
                    ->options([
                        'full_tent' => 'Full Tent (1,200,000 UGX)',
                        'shared_tent_2' => 'Shared Tent (Max 2) (600,000 UGX)',
                        'shared_tent_5' => 'Shared Tent (Max 5) (300,000 UGX)',
                    ])
                    ->nullable()
                    ->label('Exhibitor Package'),
                    
                // Dinner Package
                Forms\Components\Select::make('dinner_package')
                    ->options([
                        'table_10' => 'Table for 10 (1,000,000 UGX)',
                        'table_5' => 'Table for 5 (500,000 UGX)',
                        'individual' => 'Individual Ticket (100,000 UGX)',
                    ])
                    ->nullable()
                    ->label('Dinner Package'),
                    
                // Magazine Options
                Forms\Components\CheckboxList::make('magazine_options')
                    ->options([
                        'back_cover' => 'Back Cover (4,672,800 UGX)',
                        'inside_cover' => 'Inside Cover (3,894,000 UGX)',
                        'page3' => 'Page 3 (3,352,800 UGX)',
                        'full_page' => 'Full Page (2,336,400 UGX)',
                        'half_vertical' => 'Half Page Vertical (1,713,360 UGX)',
                        'half_horizontal' => 'Half Page Horizontal (1,401,840 UGX)',
                        'quarter' => 'Quarter Page (934,560 UGX)',
                    ])
                    ->columns(2)
                    ->nullable()
                    ->label('Magazine Options'),
                    
                Forms\Components\Textarea::make('message')
                    ->columnSpanFull(),
                    
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
                    
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                    
                // Sponsor Package
                Tables\Columns\TextColumn::make('sponsor_package')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'platinum' => 'Platinum',
                        'gold' => 'Gold',
                        'diamond' => 'Diamond',
                        'silver' => 'Silver',
                        'bronze' => 'Bronze',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'platinum' => 'success',
                        'gold' => 'warning',
                        'diamond' => 'primary',
                        'silver' => 'gray',
                        'bronze' => 'danger',
                        default => 'gray',
                    })
                    ->label('Sponsor'),
                    
                // Exhibitor Package
                Tables\Columns\TextColumn::make('exhibitor_package')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'full_tent' => 'Full Tent',
                        'shared_tent_2' => 'Shared Tent (2)',
                        'shared_tent_5' => 'Shared Tent (5)',
                        default => $state,
                    })
                    ->badge()
                    ->label('Exhibitor'),
                    
                // Dinner Package
                Tables\Columns\TextColumn::make('dinner_package')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'table_10' => 'Table (10)',
                        'table_5' => 'Table (5)',
                        'individual' => 'Individual',
                        default => $state,
                    })
                    ->badge()
                    ->label('Dinner'),
                    
                // Magazine Options
                Tables\Columns\TextColumn::make('magazine_options')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) return '-';
                        
                        $options = [
                            'back_cover' => 'Back Cover',
                            'inside_cover' => 'Inside Cover',
                            'page3' => 'Page 3',
                            'full_page' => 'Full Page',
                            'half_vertical' => 'Half Vertical',
                            'half_horizontal' => 'Half Horizontal',
                            'quarter' => 'Quarter',
                        ];
                        
                        return collect($state)
                            ->map(fn($option) => $options[$option] ?? $option)
                            ->implode(', ');
                    })
                    ->label('Magazine'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Sponsor Package Filter
                Tables\Filters\SelectFilter::make('sponsor_package')
                    ->options([
                        'platinum' => 'Platinum',
                        'gold' => 'Gold',
                        'diamond' => 'Diamond',
                        'silver' => 'Silver',
                        'bronze' => 'Bronze',
                    ])
                    ->label('Sponsor Package'),
                    
                // Exhibitor Package Filter
                Tables\Filters\SelectFilter::make('exhibitor_package')
                    ->options([
                        'full_tent' => 'Full Tent',
                        'shared_tent_2' => 'Shared Tent (2)',
                        'shared_tent_5' => 'Shared Tent (5)',
                    ])
                    ->label('Exhibitor Package'),
                    
                // Dinner Package Filter
                Tables\Filters\SelectFilter::make('dinner_package')
                    ->options([
                        'table_10' => 'Table for 10',
                        'table_5' => 'Table for 5',
                        'individual' => 'Individual Ticket',
                    ])
                    ->label('Dinner Package'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            // 'create' => Pages\CreateBusinessRegistration::route('/create'),
            // 'edit' => Pages\EditBusinessRegistration::route('/{record}/edit'),
        ];
    }
}