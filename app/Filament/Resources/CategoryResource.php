<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Posts';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Split::make([
                    Section::make([

                        TextInput::make('name')
                            ->required(),

                        TextInput::make('slug')
                            ->required(),

                        RichEditor::make('content'),
                    ]),
                    Section::make([

                        Fieldset::make('Status')
                            ->columns(1)
                            ->schema([
                                Toggle::make('published'),
                                DateTimePicker::make('published_at'),
                            ]),

                        FileUpload::make('image')
                            ->image(),

                    ])->grow(false),
                ])
                    ->from('md'),
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
                            TextEntry::make('name')
                                ->weight('bold')
                                ->hintAction(
                                    Action::make('open')
                                        ->icon('heroicon-o-arrow-top-right-on-square')
                                ),
                            TextEntry::make('slug')
                                ->color('primary'),

                            TextEntry::make('content')
                                ->alignJustify(),

                        ]),
                    \Filament\Infolists\Components\Section::make()
                        ->schema([
                            IconEntry::make('published')
                                ->boolean(),

                            TextEntry::make('published_at')
                                ->since(),

                            ImageEntry::make('image')
                                ->width(300),
                        ])
                        ->grow(false)
                        ->extraAttributes(['style' => 'min-width:300px']),
                ])
                    ->from('md'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('image')
                    ->extraImgAttributes(['class' => 'rounded-md']),

                TextColumn::make('name')
                    ->color('primary')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('content')
                    ->limit(30),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
