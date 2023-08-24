<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalloutResource\Pages;
use App\Models\Callout;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CalloutResource extends Resource
{
    protected static ?string $model = Callout::class;

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
                                        'rescue' => 'Rescue',
                                        'assist' => 'Assist',
                                        'search' => 'Search',
                                    ])
                                    ->default('rescue')
                                    ->selectablePlaceholder(false)
                                    ->required(true),
                                TextInput::make('title')
                                    ->required(true),
                                TextInput::make('location')
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
                                DateTimePicker::make('start_time'),
                                DateTimePicker::make('end_time'),
                                TextInput::make('num_team_members')
                                    ->numeric(true)
                                    ->minValue(1)
                                    ->maxValue(40)
                                    ->label('Number Of Team Members Involved')
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
                TextColumn::make('location')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('start_time')
                    ->sortable()
                    ->dateTime('D M Y h:i:s A'),
                TextColumn::make('end_time')
                    ->sortable()
                    ->dateTime('D M Y h:i:s A'),
                TextColumn::make('num_team_members')
                    ->sortable()
                    ->label('Number Of Team Members Involved'),
            ])
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
            'index' => Pages\ListCallouts::route('/'),
            'create' => Pages\CreateCallout::route('/create'),
            'edit' => Pages\EditCallout::route('/{record}/edit'),
        ];
    }
}
