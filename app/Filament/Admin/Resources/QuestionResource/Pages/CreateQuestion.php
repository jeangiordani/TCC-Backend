<?php

namespace App\Filament\Admin\Resources\QuestionResource\Pages;

use App\Filament\Admin\Resources\QuestionResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\QuestionImage;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected $image_url = null; // Definindo uma variável para armazenar a URL da imagem temporariamente

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Capture o valor de image_url e remova-o do array de dados
        $this->image_url = $data['image_url'] ?? null;
        unset($data['image_url']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Use o valor capturado de image_url para criar a entrada em question_images
        if ($this->image_url) {
            QuestionImage::create([
                'question_id' => $this->record->id,
                'path' => $this->image_url,
            ]);
        }
    }
}

