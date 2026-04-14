<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Validation\ValidationException;

class Login extends \Filament\Auth\Pages\Login
{
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Email or Username')
            ->placeholder('Enter your email or username')
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login = $data['login'];

        // Determine if input is email or name (username)
        $fieldType = $this->isEmail($login) ? 'email' : 'name';

        return [
            $fieldType => $login,
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    private function isEmail(string $input): bool
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }
}
