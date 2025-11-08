<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('post_id')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->required(),
                Select::make('user_id')
                    ->relationship('user','name')
                    ->searchable()
                    ->required(),
                Textarea::make('comment')
                ->columnSpan("full")
                    ->minLength(1)
                    ->maxLength(5000)
                    ->required(),
            ]);
    }
}
