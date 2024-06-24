<?php

namespace App\Filament\Admin\Resources\QuestionResource\Pages;

use App\Filament\Admin\Resources\QuestionResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Form;
use App\Models\QuestionImage;
use Filament\Actions;

class EditQuestion extends EditRecord
{
    protected static string $resource = QuestionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
	$questionImage = QuestionImage::where('question_id', $data['id'])->first();
	
	if ($questionImage) {
            $data['image_url'] = $questionImage->path;
        }
 
    return $data;
   }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

