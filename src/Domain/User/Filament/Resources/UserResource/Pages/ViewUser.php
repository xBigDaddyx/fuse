<?php declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource\Pages;


use Filament\Resources\Pages\ViewRecord;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource;

class ViewUser extends ViewRecord
{
    public static function getResource(): string
    {
        return UserResource::class;
    }
}
