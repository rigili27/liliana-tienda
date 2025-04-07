<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Productos';
    protected static ?string $label = 'Productos';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('family_id')
                    ->relationship('family', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('image_url')
                    ->multiple()
                    // ->panelLayout('grid')
                    ->image()
                    ->maxSize(3000)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])      
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend('product-'  . Carbon::now()->format('YmdHis') . '-'),
                    ),

                Hidden::make('position')
                ->default(1),

                Textarea::make('description')
                ->columnSpanFull(),

                Section::make('Indentificación')
                ->schema([
                    TextInput::make('sku'),
                    TextInput::make('bar_code'),
                ])->columns(2),

                Section::make('price')
                ->schema([
                    TextInput::make('price_1'),
                    TextInput::make('price_2'),
                    TextInput::make('price_3'),
                    TextInput::make('price_m_1'),
                    TextInput::make('price_m_2'),
                    TextInput::make('price_m_3'),
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Código'),
                Tables\Columns\TextColumn::make('sku')
                    ->label('Código de Origen - SKU')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('family.name')
                    ->searchable()
                    ->label('Rubro')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Sub Rubro')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Imágen'),
                Tables\Columns\TextColumn::make('price_1')
                    ->label('Precio Público 1')
                    ->numeric(locale: 'nl')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('price_2')
                    ->label('Precio Público 2')
                    ->numeric(locale: 'nl')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('price_3')
                    ->label('Precio Público 3')
                    ->numeric(locale: 'nl')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('attributes.show_name')
                    ->color('success')
                    ->badge()
                    ->label('Atributos')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TrashedFilter::make()->label('Registros eliminados'),
                Tables\Filters\SelectFilter::make('attributes')
                    ->label('Filtrar por Atributo')
                    ->placeholder('Todo')
                    ->preload()
                    ->relationship('attributes', 'show_name')
                    ->multiple()

            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\Action::make('atributos')
                    ->label('Asignar Atributos')
                    ->color('success')
                    ->icon('heroicon-o-star')
                    ->form([
                        Forms\Components\CheckboxList::make('attributes_ids') // 👈 usamos otro nombre para evitar conflictos
                            ->label('Atributos')
                            ->options(fn() => \App\Models\Attribute::pluck('show_name', 'id')) // 👈 listamos manualmente
                            ->default(fn($record) => $record->attributes->pluck('id')->toArray())
                            ->columns(1),
                    ])
                    ->action(function ($record, array $data) {
                        // Verificamos que la key exista
                        $record->attributes()->sync($data['attributes_ids'] ?? []);
                    })
                    ->modalHeading('Asignar atributos al producto'),

            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
