<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Categories', Category::count()),
            Stat::make('Posts', Post::count()),
            Stat::make('Comments', Comment::count()),
        ];
    }
}
