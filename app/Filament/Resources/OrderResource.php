<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemsRelationManager;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Mis facturas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('id')
                ->schema([
                    TextInput::make('prefix')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('letter')
                    ->required()
                    ->maxLength(255),
                ])->columns(3),

                Section::make('user')
                ->schema([
                    TextInput::make('user_name'),
                    TextInput::make('user_address'),
                    TextInput::make('user_cuit'),
                    TextInput::make('cond_iva'),
                    TextInput::make('cond_venta'),
                ])->columns(3)->collapsed(),

                Section::make('total')
                ->schema([
                    TextInput::make('neto_1')
                    ->numeric(),
                    TextInput::make('alicuota_1')
                    ->numeric(),
                    TextInput::make('imp_iva_1')
                    ->numeric(),
                    TextInput::make('neto_2')
                    ->numeric(),
                    TextInput::make('alicuota_1')
                    ->numeric(),
                    TextInput::make('imp_iva_2')
                    ->numeric(),
                    TextInput::make('neto_3')
                    ->numeric(),
                    TextInput::make('alicuota_3')
                    ->numeric(),
                    TextInput::make('imp_iva_3')
                    ->numeric(),

                    Section::make('')
                    ->schema([
                        TextInput::make('imp_interno')
                        ->numeric(),
                        TextInput::make('imp_dto')
                        ->numeric(),
                        TextInput::make('precepciones')
                        ->numeric(),
                        TextInput::make('total')
                        ->numeric(),
                    ])->columns(4),
                    
                ])->columns(3)->collapsed(),

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->query(Order::where('user_id', auth()->id()))
            // ->modifyQueryUsing(function (Builder $query){
            //     if(Auth::user()->can('only_customer_order'))
            //         return $query->where('user_id', Auth::user()->id);
            // })
            ->query(Order::query()->when(
                !auth()->user()->hasRole('admin'),
                fn($query) => $query->where('nrocuit', auth()->user()->cuit)
            ))
            
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nrocuit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('letrafactura')
                    ->label('Letra')
                    ->searchable(),
                Tables\Columns\TextColumn::make('talonario')
                    ->label('Talonario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nrocomprobante')
                    ->label('Nro Comprobante')
                    ->searchable(),
                Tables\Columns\TextColumn::make('totalgral')
                    ->label('Total Gral.')
                    ->numeric(),
                Tables\Columns\TextColumn::make('fecha')
                    ->searchable(),
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
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->label('Descargar')
                    ->hidden(fn (Order $record) => empty($record->attach))
                    ->action(function (Order $record) {

                        $decodedFile = base64_decode($record->attach, true);


                        // if (!base64_decode($decodedFile, true)) {
                        //     throw new \Exception('The attach field does not contain valid Base64 data.');
                        // }
                        
                        if ($decodedFile === false) {
                            throw new \Exception('Failed to decode Base64 data.');
                        }

                        if (strlen($decodedFile) === 0) {
                            throw new \Exception('Decoded file is empty.');
                        }


                        // $fileName = "Order_{$record->id}.pdf";
                        $fileName = "Factura {$record->letrafactura} {$record->talonario}-{$record->nrocomprobante} - {$record->nrocuit} - {$record->nombre}.pdf";

                        // Crear un archivo temporal
                        $tempPath = storage_path("app/public/{$fileName}");
                        file_put_contents($tempPath, $decodedFile);

                        // Retornar respuesta de descarga
                        return response()->download($tempPath)->deleteFileAfterSend(true);
                    })



            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            OrderItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
