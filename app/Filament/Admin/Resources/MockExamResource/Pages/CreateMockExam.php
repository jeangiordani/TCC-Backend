<?php

namespace App\Filament\Admin\Resources\MockExamResource\Pages;

use App\Filament\Admin\Resources\MockExamResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMockExam extends CreateRecord
{
    protected static string $resource = MockExamResource::class;
}
