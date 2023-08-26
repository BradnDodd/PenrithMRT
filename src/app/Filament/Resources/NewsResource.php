<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('type')
                                    ->options([
                                        'team-news' => 'Team News',
                                        'press-release' => 'Press Release',
                                    ])
                                    ->default('team-news')
                                    ->selectablePlaceholder(false)
                                    ->required(true),
                                TextInput::make('title')
                                    ->required(true),
                                TextInput::make('subtitle')
                                    ->required(true),
                                MarkdownEditor::make('description')
                                    ->toolbarButtons([
                                        'bold',
                                        'bulletList',
                                        'edit',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'preview',
                                        'strike',
                                    ])
                                    ->columnSpanFull()
                                    ->required(true),
                            ])->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('subtitle'),
                TextColumn::make('type')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->label('Date Created')
                    ->sortable()
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
