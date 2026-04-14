<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('email'),
                Select::make('class_id')
                    ->relationship('class', 'name')
                    ->live()
                    ->native(false)
                    ->required(),
                Select::make('section_id')
                    ->relationship(
                        'section',
                        'name',
                        fn (Get $get, $query) => $query->where(
                            'class_id',
                            $get('class_id')
                        )
                    )->native(false)
                    ->hidden(fn (Get $get) => ! $get('class_id'))
                    ->required(),

            ]);
    }
}
