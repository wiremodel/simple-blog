<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    public function mount(): void
    {
        parent::mount();

        $this->activeTab = session('postActiveTab', $this->getDefaultActiveTab());
    }

    public function updatedActiveTab(): void
    {
        parent::updatedActiveTab();
        session(['postActiveTab' => $this->activeTab]);
    }

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
