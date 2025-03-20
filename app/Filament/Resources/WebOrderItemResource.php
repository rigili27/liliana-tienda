<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebOrderItemResource\Pages;
use App\Filament\Resources\WebOrderItemResource\RelationManagers;
use App\Models\WebOrderItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebOrderItemResource extends Resource
{
    protected static ?string $model = WebOrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Desarrolladores';
    

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('developer');
    }

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
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebOrderItems::route('/'),
            'create' => Pages\CreateWebOrderItem::route('/create'),
            'edit' => Pages\EditWebOrderItem::route('/{record}/edit'),
        ];
    }
}
