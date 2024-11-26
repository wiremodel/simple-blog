<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    protected static ?string $navigationGroup = 'Posts';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title')
                    ->color('primary'),

                TextEntry::make('post.title'),

                TextEntry::make('user.name')
                    ->label('Author'),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('content')
                    ->prose()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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

                ToggleColumn::make('published'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('post_id')
                    ->label('Post')
                    ->relationship('post', 'title')
                    ->preload()
                    ->multiple(),
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Author')
                    ->relationship('user', 'name')
                    ->preload()
                    ->multiple(),
                Filter::make('published_at')
                    ->form([
                        DatePicker::make('published_from'),
                        DatePicker::make('published_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageComments::route('/'),
        ];
    }
}
