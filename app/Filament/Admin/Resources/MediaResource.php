<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('path')
                    ->label('Arquivo')
                    ->directory('uploads')
                    ->disk('public')
                    ->unique($table = 'medias', $column = 'path'),

                Forms\Components\Select::make('type')
                ->label('Tipo')
                ->options([
                    'image' => 'Imagem',
                    'video' => 'Video',
                    'audio' => 'Audio',
                    'PDF' => 'PDF'
                ])
                ->required(),
                Forms\Components\TextInput::make('subject')
                ->label('Assunto')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('path')->url(fn (Media $record) => asset('storage/' . $record->path))
                    ->label('Arquivo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->label('Assunto')
                    ->searchable()
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
