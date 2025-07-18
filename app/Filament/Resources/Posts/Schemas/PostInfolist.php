<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                ImageEntry::make('image')
                    ->disk('public')
                    ->hiddenLabel()
                    ->imageWidth('100%')
                    ->imageHeight('350px'),
                TextEntry::make('title')
                    ->size('lg')
                    ->hiddenLabel(),
                TextEntry::make('content')
                    ->prose()
                    ->hiddenLabel(),
                TextEntry::make('user.name')
                    ->label('Author'),
                TextEntry::make('published_at')
                    ->since(),
            ]);
    }
}
