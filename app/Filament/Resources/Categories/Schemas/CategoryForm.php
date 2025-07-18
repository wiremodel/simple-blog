<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Flex::make([
                    Section::make([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('slug')
                            ->required(),
                        RichEditor::make('content')
                            ->columnSpanFull(),

                    ]),
                    Section::make([
                        FileUpload::make('image')
                            ->disk('public')
                            ->image(),

                        Fieldset::make('Publishing Options')
                            ->columns(1)
                            ->schema([
                                Toggle::make('published'),
                                DateTimePicker::make('published_at'),
                            ]),
                    ])
                        ->grow(false)
                        ->extraAttributes(['style' => 'min-width: 400px;']),
                ])->from('xl'),
            ]);
    }
}
