<?php declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\PermissionResource\Pages;

use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\PermissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    public static function getResource(): string
    {
        return PermissionResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
