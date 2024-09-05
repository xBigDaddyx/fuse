<?php

namespace Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource\Pages;

use Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCompany extends ViewRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->visible(fn ():bool=>auth()->user()->can('update_company')),
        ];
    }
}
