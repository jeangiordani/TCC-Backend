<?php

namespace App\Filament\Admin\Resources\AlternativeResource\Pages;

use App\Filament\Admin\Resources\AlternativeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlternatives extends ListRecords
{
    protected static string $resource = AlternativeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
