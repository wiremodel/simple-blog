<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->description('Fill in the user details below.')
                    ->columns(1)
                    ->icon(Heroicon::User)
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->revealable()
                            ->password()
                            ->confirmed()
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->revealable()
                            ->password()
                            ->dehydrated(false)
                            ->visibleJs('$get(\'password\')'),
                    ]),
            ]);
    }
}
