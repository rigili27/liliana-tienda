<?php

namespace App\Filament\Resources;

use App\Enums\WebOrderStatus;
use App\Filament\Resources\WebOrderResource\Pages;
use App\Filament\Resources\WebOrderResource\RelationManagers;
use App\Filament\Resources\WebOrderResource\RelationManagers\WebOrderItemsRelationManager;
use App\Models\WebOrder;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebOrderResource extends Resource
{
    protected static ?string $model = WebOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Compras';
    protected static ?string $label = 'Mis Compras Web';

    // Badges para info
    public static function getNavigationBadge(): ?string
    {
        return 'En construcción';
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
    // Badges para info

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->default(auth()->user()->id)
                    ->required()
                    ->numeric(),
                ToggleButtons::make('status')
                    ->inline()
                    ->default('pending')
                    ->options(WebOrderStatus::class),
                Forms\Components\DatePicker::make('date')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nro Orden')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Importe total')
                    ->numeric(locale: 'nl')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            WebOrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebOrders::route('/'),
            'create' => Pages\CreateWebOrder::route('/create'),
            'edit' => Pages\EditWebOrder::route('/{record}/edit'),
        ];
    }
}
