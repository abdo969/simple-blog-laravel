<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Main Content')
                    ->schema([
                        TextInput::make('title')
                            ->live(false, 1000)->required()->minLength(1)->maxLength(255)
                            ->afterStateUpdated(function ($operation, ?string $state, callable $set) {
                                if ($state !== null && $operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->required()->unique(ignoreRecord: true)->minLength(1)->maxLength(255),
                        FileUpload::make('image')
                            ->image()
                            ->downloadable()
                            ->directory('posts/thumbnails')
                            ->disk('public')
                            ->reorderable()
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->extraAttributes(['class' => 'h-120px'])
                            ->fileAttachmentsDirectory('posts/media')
                            ->columnSpanFull(),
                    ])->columns(2)->collapsible()->columnSpanFull(),
                Section::make('Meta Data')
                    ->schema([
                        Select::make('user_id')
                            ->label('Author')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('categories')
                            ->label('Category')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->searchable(),
                        DateTimePicker::make('published_at')->timezone('EEST')->nullable()->seconds(false), // User's timezone for display,
                        Toggle::make('featured'),
                    ])->columns(2)->collapsible()->columnSpanFull(),
            ]);
    }
}
