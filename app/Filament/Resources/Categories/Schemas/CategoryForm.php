<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->live(false, 1000)->required()->minLength(1)->maxLength(255)
                    ->afterStateUpdated(function ($operation, ?string $state, callable $set) {
                        if ($state !== null && $operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')
                    ->required()->unique(ignoreRecord: true)->minLength(1)->maxLength(255),
                ColorPicker::make('text_color')
                    ->default(null),
                ColorPicker::make('bg_color')
                    ->default(null),
                FileUpload::make('image')
                    ->image(),
            ]);
    }
}
