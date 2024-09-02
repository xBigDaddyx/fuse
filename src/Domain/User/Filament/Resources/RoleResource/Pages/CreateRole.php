<?php
namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\RoleResource\Pages;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\PermissionRegistrar;

class CreateRole extends CreateRecord
{
    public static function getResource(): string
    {
        return RoleResource::class;
    }

    public function afterCreate(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['guard_name'] = 'web';

        return $data;
    }
}
