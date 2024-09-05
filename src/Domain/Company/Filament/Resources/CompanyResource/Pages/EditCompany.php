<?php

namespace Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource\Pages;

use Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompany extends EditRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
            ->visible(fn ():bool=>auth()->user()->can('viewAny_company')),
            Actions\DeleteAction::make()
            ->visible(fn ():bool=>auth()->user()->can('delete_company')),
        ];
    }
}
