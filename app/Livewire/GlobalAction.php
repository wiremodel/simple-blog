<?php

namespace App\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Livewire\Component;

class GlobalAction extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function confirmPasswordAction(): Action
    {
        return Action::make('confirmPassword')
            ->modalHeading('Confirm your password')
            ->modalDescription('Please enter your password to proceed.')
            ->modalWidth(Width::ExtraSmall)
            ->closeModalByClickingAway(false)
            ->modalCancelAction(false)
            ->closeModalByEscaping(false)
            ->modalCloseButton(false)
            ->modalSubmitAction(false)
            ->schema([
                TextInput::make('password')
                    ->hiddenLabel()
                    ->required()
                    ->placeholder('******')
                    ->password()
                    ->suffixAction(Action::make('confirmPassword')
                        ->icon(Heroicon::LockOpen)
                        ->action(function (Action $action, array $data) {

                            // Here you would typically verify the password.
                            // For demonstration, we assume the password is always correct.

                            $action->cancelParentActions();

                            Notification::make()
                                ->title('Password confirmed!')
                                ->success()
                                ->send();
                        })),
            ]);
    }

    public function render(): string
    {
        return <<<'HTML'
            <div wire:init="triggerAction">
                <x-filament-actions::modals />
            </div>
        HTML;
    }

    public function triggerAction(): void
    {
        if (! auth()->check()) {
            return;
        }

        $this->mountAction('confirmPassword');
    }
}
