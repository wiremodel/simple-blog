<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Tabs::make('Tabs')
                    ->vertical()
                    ->schema([
                        Tabs\Tab::make('Post')
                            ->columns(2)
                            ->icon(Heroicon::OutlinedDocument)
                            ->schema([
                                TextInput::make('title')
                                    ->required(),
                                TextInput::make('slug')
                                    ->required(),
                                Textarea::make('excerpt')
                                    ->afterLabel(new HtmlString(<<<'HTML'
                                        <span
                                            x-data="{ get remaining() { return 255 - $state.length } }"
                                            x-text="remaining"
                                            :class="remaining >= 0 ? 'text-success-500' : 'text-danger-500'"
                                        >
                                        </span>
                                    HTML))
                                    ->rows(3)
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                RichEditor::make('content')
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Images')
                            ->icon(Heroicon::OutlinedPhoto)
                            ->columns(2)
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->panelLayout('grid')
                                    ->disk('public')
                                    ->image(),
                                FileUpload::make('featured_image')
                                    ->panelLayout('grid')
                                    ->disk('public')
                                    ->image(),

                                FileUpload::make('gallery')
                                    ->panelLayout('grid')
                                    ->disk('public')
                                    ->multiple()
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Tags')
                            ->icon(Heroicon::OutlinedTag)
                            ->schema([
                                TagsInput::make('tags')
                                    ->placeholder('Add tags...')
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Status')
                            ->icon(Heroicon::OutlinedQuestionMarkCircle)
                            ->badge(fn (?Post $record) => $record
                                ->status
                                ->value ?? 'draft'
                            )
                            ->badgeColor(fn (?Post $record) => match ($record?->status) {
                                default => 'gray',
                                PostStatus::Draft => 'gray',
                                PostStatus::Published => 'success',
                                PostStatus::Archived => 'danger',
                            })
                            ->columns(2)
                            ->schema([
                                ToggleButtons::make('status')
                                    ->options(PostStatus::class)
                                    ->default('draft')
                                    ->required()
                                    ->inline(),
                                DateTimePicker::make('published_at')
                                    ->label('Publish At')
                                    ->default(now())
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
