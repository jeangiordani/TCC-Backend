<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuestionResource\Pages;
use App\Filament\Admin\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $modelLabel = 'Questão';
    protected static ?string $navigationLabel = 'Questões';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('statement')
                    ->label('Enunciado')
                    ->required(),
                Forms\Components\TextInput::make('post_statement')
                    ->label('Pós-enunciado')
                    ->required(),
                Forms\Components\Select::make('is_active')
                    ->label('Ativo')
                    ->options(
                        [
                            0 => 'Não',
                            1 => 'Sim'
                        ]
                    ),
                Forms\Components\Select::make('knowledge_area_id')
                    ->relationship('knowledge_area', 'name')
                    ->label('Disciplina'),
                // Forms\Components\Select::make('id')
                //     ->relationship('alternatives', 'description')
                //     ->label('Alternativas')
                // ->createOptionForm(
                //     [
                //         Forms\Components\Select::make('letter')
                //             ->options(
                //                 [
                //                     'a' => 'a',
                //                     'b' => 'b',
                //                     'c' => 'c',
                //                     'd' => 'd',
                //                     'e' => 'e',
                //                 ]
                //             )
                //             ->label('Letra')
                //             ->required(),
                //         Forms\Components\TextInput::make('description')
                //             ->required()
                //             ->label('Descrição'),
                //         Forms\Components\Select::make('is_correct')
                //             ->options(
                //                 [
                //                     0 => 'Não',
                //                     1 => 'Sim'
                //                 ]
                //             )
                //             ->label('Correta')
                //             ->required(),
                //         Forms\Components\Select::make('question_id')
                //             ->relationship('question', 'id')
                //             ->label('Questão'),
                //     ]
                // )->visible(fn ($livewire) => $livewire->record !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('statement')
                    ->label('Enunciado')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('is_active')
                    ->label('Ativo'),
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
            RelationManagers\AlternativesRelationManager::class,
            // RelationManagers\KnowledgeAreaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return 'Questões';

    }
}
