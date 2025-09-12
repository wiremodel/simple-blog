<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use App\Filament\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Categories\Tables\CategoriesTable;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return CategoriesTable::configure($table)
            ->headerActions([
                CreateAction::make()
                    ->after(fn () => $this->dispatch('refresh-page')),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->after(fn () => $this->dispatch('refresh-page')),
            ]);
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord
            ->categories()
            ->count() ?: 0;
    }
}
