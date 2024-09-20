<?php

namespace Xbigdaddyx\Fuse\Domain\System\Filament\Resources\PanelResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Xbigdaddyx\Fuse\Domain\System\Filament\Resources\PanelResource;

class ManagePanels extends ManageRecords
{
    protected static string $resource = PanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
