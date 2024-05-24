<?php

namespace App\Filament\Admin\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Filament\Admin\Resources\MockExamResource\Pages;
use App\Filament\Admin\Resources\MockExamResource\RelationManagers;
use App\Models\MockExam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MockExamResource extends Resource
{
    protected static ?string $model = MockExam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Simulado';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->placeholder('Título do simulado'),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->required()
                    ->placeholder('Descrição do simulado'),
                Forms\Components\TextInput::make('qty_questions')
                    ->label('Quantidade')
                    ->placeholder('Quantidade de questões')
                    ->integer(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Usuário'),
                Forms\Components\Select::make('knowledge_area_id')
                    ->relationship('knowledge_area', 'name')
                    ->label('Área de conhecimento'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição'),
                Tables\Columns\TextColumn::make('qty_questions')
                    ->label('Quantidade'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário'),
                Tables\Columns\TextColumn::make('knowledge_area.name')
                    ->label('Área de Conhecimento')
                    ->searchable()
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
            RelationManagers\UsersRelationManager::class,
            RelationManagers\KnowledgeAreasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMockExams::route('/'),
            'create' => Pages\CreateMockExam::route('/create'),
            'edit' => Pages\EditMockExam::route('/{record}/edit'),
        ];
    }
}
