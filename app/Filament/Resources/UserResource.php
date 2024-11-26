<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Users';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->rule(Password::default())
                    ->autocomplete(false)
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->live(debounce: 500)
                    ->same('passwordConfirmation'),

                TextInput::make('passwordConfirmation')
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->visible(fn (Get $get): bool => filled($get('password')))
                    ->dehydrated(false),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('name')
                ->label('Name'),

            TextEntry::make('email')
                ->label('Email'),

            TextEntry::make('email_verified_at')
                ->dateTime('d/m/Y H:i'),

            IconEntry::make('author')
                ->boolean()
                ->state(fn (User $record): bool => $record->posts()->exists()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('email')
                    ->color('primary')
                    ->searchable(),

                IconColumn::make('author')
                    ->boolean()
                    ->state(fn (User $record): bool => $record->posts()->exists()),

                TextColumn::make('email_verified_at')
                    ->dateTime('d/m/Y H:i')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
