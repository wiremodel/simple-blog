<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use App\Filament\Resources\CategoryResource;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public function form(Form $form): Form
    {
        return CategoryResource::form($form);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return CategoryResource::infolist($infolist);
    }

    public function table(Table $table): Table
    {
        return CategoryResource::table($table)
            ->recordTitleAttribute('name')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->iconButton()
                    ->icon('heroicon-o-plus'),
            ]);
    }
}
