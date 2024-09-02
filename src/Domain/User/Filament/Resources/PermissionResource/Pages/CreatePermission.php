<?php declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\PermissionResource\Pages;

use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\PermissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    public static function getResource(): string
    {
        return PermissionResource::class;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['guard_name'] = 'web';

        return $data;
    }
}
