<?php

namespace App\Livewire;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Livewire\Component;

class QuickCreatePost extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function newPostAction(): Action
    {
        return Action::make('newPost')
            ->icon(Heroicon::Plus)
            ->label(Html::make('<span x-show="$store.sidebar.isOpen">Quick Create Post</span>'))
            ->outlined()
            ->extraAttributes(['class' => 'w-full'])
            ->tooltip('Quick Create Post')
            ->url(PostResource::getUrl('create'));
    }

    public function render()
    {
        return view('livewire.quick-create-post');
    }
}
