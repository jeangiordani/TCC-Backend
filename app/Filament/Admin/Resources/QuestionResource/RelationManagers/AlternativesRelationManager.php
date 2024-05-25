<?php

namespace App\Filament\Admin\Resources\QuestionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlternativesRelationManager extends RelationManager
{
    protected static string $relationship = 'alternatives';
    protected static ?string $title = 'Alternativas';
    protected static ?string $modelLabel = 'Alternativa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('letter')
                    ->options(
                        [
                            'a' => 'a',
                            'b' => 'b',
                            'c' => 'c',
                            'd' => 'd',
                            'e' => 'e',
                        ]
                    )
                    ->label('Letra')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->label('Descrição'),
                Forms\Components\Select::make('is_correct')
                    ->options(
                        [
                            false => 'Não',
                            true => 'Sim'
                        ]
                    )
                    ->label('Correta')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('letter')
                    ->label('Letra'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição'),
                Tables\Columns\TextColumn::make('is_correct')
                    ->formatStateUsing(fn ($record) => $record->is_correct == true ? 'Sim' : 'Não')
                    ->label('Correta'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->heading('Alternativas');
    }
}
