<?php

namespace Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource\Pages;

use Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->visible(fn ():bool=>auth()->user()->can('create_company')),
        ];
    }
}
