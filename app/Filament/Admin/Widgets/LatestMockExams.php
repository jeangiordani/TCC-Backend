<?php

namespace App\Filament\Admin\Widgets;

use App\Models\MockExam;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class LatestMockExams extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                MockExam::query()
                    ->latest()
                    ->limit(10)

            )
            ->columns([
                TextColumn::make('title')
                    ->searchable()
		    ->sortable()
	    	    ->label('Título'),
                TextColumn::make('qty_questions')
                    ->searchable()
		    ->sortable()
		    ->label('Quantidade'),
                TextColumn::make('user.name')
                    ->searchable()
		    ->sortable()
	    	    ->label('Usuário'),
	    ])
	    ->heading('Útimos Simulados');
    }
}
