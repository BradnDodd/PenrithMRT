<?php

namespace App\Filament\Resources\CalloutResource\Pages;

use App\Filament\Resources\CalloutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCallouts extends ListRecords
{
    protected static string $resource = CalloutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
