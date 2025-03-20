<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobStatusResource\Pages;
use App\Filament\Resources\JobStatusResource\RelationManagers;
use App\Jobs\FamilyCreateHandlerJob;
use App\Jobs\OrderCreateHandlerJob;
use App\Jobs\ProductCreateHandlerJob;
use App\Jobs\UserCreateHandlerJob;
use App\Models\JobStatus;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Novadaemon\FilamentPrettyJson\PrettyJson;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class JobStatusResource extends Resource
{
    protected static ?string $model = JobStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';

    protected static ?string $navigationGroup = 'Desarrolladores';
    protected static ?string $label = 'Trabajos';

    // Badges para info
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'in_progress')->count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }
    // Badges para info

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin|developer');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('job_name')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),

                DatePicker::make('created_at')
                    ->format('d/m/Y')
                    ->disabled(),

                PrettyJson::make('payload')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('pending')
                    ->disabled(),
                Forms\Components\TextInput::make('progress')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->disabled(),
                Forms\Components\Textarea::make('error_message')
                    ->columnSpanFull()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job_name')
                    ->searchable(),
                IconColumn::make('status')
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'in_progress' => 'heroicon-o-play-circle',
                        'completed' => 'heroicon-o-check-circle',
                        'failed' => 'heroicon-o-exclamation-triangle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'info',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('progress')
                    ->suffix('%')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
                Action::make('retry')
                    ->label('Retry Job')
                    ->color('info')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->action(function (JobStatus $record) {
                        try {
                            // Asegúrate de que el payload sea un array antes de usarlo
                            $payload = json_decode($record->payload, true);
                            if (!is_array($payload)) {
                                throw new \Exception('El payload es inválido o no contiene productos.');
                            }

                            Artisan::call('queue:work --stop-when-empty');
                            
                            // Reprogramar el Job
                            if ($record->job_name == 'ProductCreateHandlerJob')
                                ProductCreateHandlerJob::dispatch($payload, $record->id);
                            elseif ($record->job_name == 'FamilyCreateHandlerJob')
                                FamilyCreateHandlerJob::dispatch($payload, $record->id);
                            elseif ($record->job_name == 'UserCreateHandlerJob')
                                UserCreateHandlerJob::dispatch($payload, $record->id);
                            elseif ($record->job_name == 'OrderCreateHandlerJob')
                                OrderCreateHandlerJob::dispatch($payload, $record->id);

                            // Actualizar el estado del Job
                            $record->update(['status' => 'pending', 'progress' => 0, 'error_message' => null]);

                            Log::info("Job reprogramado exitosamente", ['job_status_id' => $record->id]);
                        } catch (\Exception $e) {
                            Log::error("Error al reprogramar el Job", ['message' => $e->getMessage()]);
                            throw new \RuntimeException('No se pudo reprogramar el Job: ' . $e->getMessage());
                        }
                    }),
            ])
            
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('id', 'desc');
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
            'index' => Pages\ListJobStatuses::route('/'),
            'create' => Pages\CreateJobStatus::route('/create'),
            'edit' => Pages\EditJobStatus::route('/{record}/edit'),
        ];
    }
}
