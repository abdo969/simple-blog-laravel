<?php

namespace App\Filament\Resources\Comments\Widgets;

use App\Filament\Resources\Comments\CommentResource;
use App\Models\Comment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LatestCommentsWidget extends TableWidget
{
    protected static ?int $sort = 3;
    public function table(Table $table): Table
    {
        return $table
        ->recordUrl(
            fn (Model $record): string => CommentResource::getUrl('edit', ['record' => $record])
        )
            ->query(fn (): Builder => Comment::WhereDate("created_at", '>=', now()->subDays(14)))
            ->columns([
                TextColumn::make('post.title')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->sortable(),
                TextColumn::make('comment')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                EditAction::make()->form(
                    [
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
                    ]
                ),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
