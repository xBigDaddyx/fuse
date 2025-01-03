<?php

declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource\Pages;


use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\PermissionRegistrar;

class EditUser extends EditRecord
{
    public static function getResource(): string
    {
        return \Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource::class;
    }

    public function afterSave(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn(Model $record): bool => auth()->user()->can('delete_user') && $record->companies->isEmpty()),
        ];
    }
}
