<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $modelLabel = 'Usuário';
    
    
    public static function form(Form $form): Form
    {
        return $form->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->placeholder('John Doe'),
	   	Forms\Components\TextInput::make('email')
		    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->required()
                    ->password()
		    ->placeholder('Password')
	    	    ->visibleOn('create'),
                Forms\Components\Select::make('role')
                    ->options([
                        'ALUNO' => 'ALUNO',
                        'PROFESSOR' => 'PROFESSOR',
                        'ADMIN' => 'ADMIN',
		    ])
		    ->label('Perfil'),
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
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
		    ->sortable()
	    	    ->label('Email'),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
		    ->sortable()
	    	    ->label('Perfil'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'ALUNO' => 'ALUNO',
                        'PROFESSOR' => 'PROFESSOR',
                        'ADMIN' => 'ADMIN',
		    ])
		    ->label('Perfil'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
