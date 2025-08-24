<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Enums\PostStatus;
use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
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
            'all' => Tab::make()
                ->icon(Heroicon::OutlinedQueueList),

            'draft' => Tab::make()
                ->icon(PostStatus::Draft->getIcon())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereStatus(PostStatus::Draft)),

            'published' => Tab::make()
                ->icon(PostStatus::Published->getIcon())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereStatus(PostStatus::Published)),

            'archived' => Tab::make()
                ->icon(PostStatus::Archived->getIcon())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereStatus(PostStatus::Archived)),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

}
