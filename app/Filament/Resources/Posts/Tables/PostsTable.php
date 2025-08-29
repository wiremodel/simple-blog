<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PostStatus;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->imageSize('40px')
                    ->placeholder('#'),
ViewColumn::make('title')
    ->view('components.tables.columns.post-title')
    ->action(
        Action::make('quickEdit')
            ->modalWidth(Width::Small)
            ->modalSubmitActionLabel('Save Changes')
            ->fillForm(fn (Post $record) => [
                'title' => $record->title,
            ])
            ->schema([
                TextInput::make('title')
                    ->autocomplete(false)
                    ->required(),
            ])
            ->action(function (Post $record, array $data) {
                $record->update([
                    'title' => $data['title'],
                ]);

                Notification::make()
                    ->title('Post title updated successfully')
                    ->success()
                    ->send();
            })
    )
    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),
                SelectColumn::make('status')
                    ->options(PostStatus::class),
                TextColumn::make('published_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Categories'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
