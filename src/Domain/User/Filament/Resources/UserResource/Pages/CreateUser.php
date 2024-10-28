<?php

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\PermissionRegistrar;
use Xbigdaddyx\Fuse\Domain\User\Events\UserRegisteredEvent;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource;

class CreateUser extends CreateRecord
{
    public static function getResource(): string
    {
        return UserResource::class;
    }
    // protected function afterCreate($user): void
    // {

    //     event(new UserRegisteredEvent($user));
    // }
}
