<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->submit(null)
            ->requiresConfirmation()
            ->action(function () {
                $actionId = str('fi-')
                    ->append($this->getId())
                    ->append('-action-0')
                    ->toString();

                $this->dispatch('close-modal', id: $actionId);
                $this->create();
            });
    }
}
