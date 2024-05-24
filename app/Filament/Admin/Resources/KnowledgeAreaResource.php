<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KnowledgeAreaResource\Pages;
use App\Filament\Admin\Resources\KnowledgeAreaResource\RelationManagers;
use App\Models\KnowledgeArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KnowledgeAreaResource extends Resource
{
    protected static ?string $model = KnowledgeArea::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Área de Conhecimento';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->placeholder('Nome da área de conhecimento'),
                Forms\Components\Select::make('is_active')
                    ->label('Ativo')
                    ->options([
                        1 => 'Sim',
                        0 => 'Não',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_active')
                    ->label('Ativo')
                    ->sortable(),
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
            'index' => Pages\ListKnowledgeAreas::route('/'),
            'create' => Pages\CreateKnowledgeArea::route('/create'),
            'edit' => Pages\EditKnowledgeArea::route('/{record}/edit'),
        ];
    }
}
