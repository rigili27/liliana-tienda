<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanySettingResource\Pages;
use App\Models\CompanySetting;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TimePicker;

class CompanySettingResource extends Resource
{
    protected static ?string $model = CompanySetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Empresa';
    protected static ?string $label = 'Horario';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // KeyValue::make('business_hours')
                //     ->label('Horarios de atención')
                //     ->helperText('Define los horarios de apertura y cierre para cada día.')
                //     ->keyLabel('Día (ej. lunes)')
                //     ->valueLabel('Horarios (ej. {"open": "08:00", "close": "12:00"})')
                //     ->json()
                //     ->columnSpanFull(),

                Repeater::make('business_hours')
                    ->label('Horarios de atención')
                    ->schema([
                        Select::make('day')
                            ->label('Día de la semana')
                            ->options([
                                'monday' => 'Lunes',
                                'tuesday' => 'Martes',
                                'wednesday' => 'Miércoles',
                                'thursday' => 'Jueves',
                                'friday' => 'Viernes',
                                'saturday' => 'Sábado',
                                'sunday' => 'Domingo',
                            ])
                            ->required(),

                        Grid::make(2)->schema([
                            TimePicker::make('open')
                                ->label('Apertura mañana')
                                ->withoutSeconds()
                                ->nullable(),

                            TimePicker::make('close')
                                ->label('Cierre mañana')
                                ->withoutSeconds()
                                ->nullable(),
                        ]),

                        Grid::make(2)->schema([
                            TimePicker::make('open_afternoon')
                                ->label('Apertura tarde')
                                ->withoutSeconds()
                                ->nullable(),

                            TimePicker::make('close_afternoon')
                                ->label('Cierre tarde')
                                ->withoutSeconds()
                                ->nullable(),
                        ]),
                    ])
                    ->columnSpanFull(),

                // Repeater::make('payment_methods')
                //     ->label('Medios de pago')
                //     ->schema([
                //         TextInput::make('method')->label('Método de pago'),
                //     ])
                //     ->addable()
                //     ->deletable()
                //     ->columnSpanFull(),

                // Repeater::make('delivery_methods')
                //     ->label('Medios de entrega')
                //     ->schema([
                //         TextInput::make('method')->label('Método de entrega'),
                //     ])
                //     ->addable()
                //     ->deletable()
                //     ->columnSpanFull(),

                // Toggle::make('show_catalog')
                //     ->label('Mostrar catálogo dentro del horario establecido')
                //     ->helperText('Si está activado, el catálogo solo se mostrará en los horarios definidos.')
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('business_hours')->label('Horarios')->limit(50),
                // TextColumn::make('payment_methods')->label('Medios de pago')->limit(50),
                // TextColumn::make('delivery_methods')->label('Medios de entrega')->limit(50),
                // TextColumn::make('show_catalog')->label('Mostrar catálogo')->boolean(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanySettings::route('/'),
            'edit' => Pages\EditCompanySetting::route('/{record}/edit'),
        ];
    }
}
