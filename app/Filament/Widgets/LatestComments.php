<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestComments extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Comment::latest()->limit(10))
            ->paginated(false)
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('post.title')
                    ->hidden(fn ($livewire) => str($livewire->getName())->contains('comments-relation-manager'))
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                ToggleColumn::make('published'),

            ]);
    }
}
