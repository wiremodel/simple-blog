<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

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
        return [
            Actions\CreateAction::make(),
        ];
    }
}
