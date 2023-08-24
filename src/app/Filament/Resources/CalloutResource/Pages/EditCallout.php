<?php

namespace App\Filament\Resources\CalloutResource\Pages;

use App\Filament\Resources\CalloutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCallout extends EditRecord
{
    protected static string $resource = CalloutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
