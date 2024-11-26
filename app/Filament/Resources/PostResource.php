<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers\CategoriesRelationManager;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Posts';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Split::make([
                    Section::make([

                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state, Page $livewire) {
                                if (blank($get('slug'))) {
                                    $set('slug', str($state)->slug());
                                    $livewire->validateOnly('data.slug');
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->unique(column: 'slug', ignoreRecord: true)
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (Page $livewire, ?string $state, TextInput $component) {
                                $component->state(str($state)->slug());
                                $livewire->validateOnly($component->getStatePath());
                            }),

                        RichEditor::make('content')
                            ->columnSpanFull(),

                        TagsInput::make('tags'),
                    ]),

                    Section::make([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Author'),
                        Fieldset::make('Status')
                            ->schema([
                                Toggle::make('published'),
                                DateTimePicker::make('published_at'),
                            ])->columns(1),

                        FileUpload::make('image')
                            ->image(),

                    ])->grow(false),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                \Filament\Infolists\Components\Split::make([
                    \Filament\Infolists\Components\Section::make()
                        ->schema([
                            TextEntry::make('title')
                                ->weight('bold')
                                ->hintAction(
                                    Action::make('open')
                                        ->icon('heroicon-o-arrow-top-right-on-square')
                                ),
                            TextEntry::make('slug')
                                ->color('primary'),

                            TextEntry::make('content')
                                ->alignJustify(),

                            TextEntry::make('categories.name')
                                ->badge(),

                            TextEntry::make('tags')
                                ->badge(),
                        ]),
                    \Filament\Infolists\Components\Section::make()
                        ->schema([
                            TextEntry::make('user.name')
                                ->label('Author'),
                            IconEntry::make('published')
                                ->boolean(),
                            TextEntry::make('published_at')
                                ->since(),
                            ImageEntry::make('image')
                                ->width(300),
                        ])
                        ->grow(false)
                        ->extraAttributes(['style' => 'min-width:300px']),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->extraImgAttributes(['class' => 'rounded-md']),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('user.name')
                    ->sortable()
                    ->label('Author'),

                ToggleColumn::make('published'),

                TextColumn::make('published_at')
                    ->since()
                    ->sortable(),

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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
