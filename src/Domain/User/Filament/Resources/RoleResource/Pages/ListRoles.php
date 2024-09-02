<?php declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\RoleResource\Pages;


use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\RoleResource;
class ListRoles extends ListRecords
{
    public static function getResource(): string
    {
        return RoleResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
