<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageComments extends ManageRecords
{
    protected static string $resource = CommentResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'published' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->wherePublished(true)),
            'unpublished' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->wherePublished(false)),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
