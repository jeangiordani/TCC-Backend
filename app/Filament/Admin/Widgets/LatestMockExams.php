<?php

namespace App\Filament\Admin\Widgets;

use App\Models\MockExam;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class LatestMockExams extends BaseWidget
{
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
                    ->sortable(),
                TextColumn::make('qty_questions')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('knowledge_area.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
            ]);
    }
}
