<?php declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\PermissionResource\Pages;

use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\PermissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    public static function getResource(): string
    {
        return PermissionResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
