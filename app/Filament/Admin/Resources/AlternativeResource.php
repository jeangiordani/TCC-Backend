<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AlternativeResource\Pages;
use App\Filament\Admin\Resources\AlternativeResource\RelationManagers;
use App\Models\Alternative;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlternativeResource extends Resource
{
    protected static ?string $model = Alternative::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $modelLabel = 'Alternativa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('letter')
                    ->label('Letra')
                    ->required()
                    ->options(
                        [
                            'a' => 'a',
                            'b' => 'b',
                            'c' => 'c',
                            'd' => 'd',
                            'e' => 'e',
                        ]
                    ),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->required(),
                Forms\Components\Select::make('is_correct')
                    ->label('Correta')
                    ->options(
                        [
                            false => 'Não',
                            true => 'Sim'
                        ]
                    ),
                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'id')
                    ->label('Questão')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('letter')
                    ->label('Letra')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_correct')
                    ->formatStateUsing(fn ($record) => $record->is_correct == true ? 'Sim' : 'Não')
                    ->label('Correta'),
                Tables\Columns\TextColumn::make('question.statement')
                    ->label('Questão')
                    ->searchable()
                    ->limit(10),
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
            RelationManagers\QuestionRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlternatives::route('/'),
            'create' => Pages\CreateAlternative::route('/create'),
            'edit' => Pages\EditAlternative::route('/{record}/edit'),
        ];
    }
}
