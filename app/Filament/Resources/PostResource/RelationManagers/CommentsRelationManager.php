<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use App\Filament\Resources\CommentResource;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return CommentResource::infolist($infolist);
    }

    public function table(Table $table): Table
    {
        return CommentResource::table($table);
    }
}
