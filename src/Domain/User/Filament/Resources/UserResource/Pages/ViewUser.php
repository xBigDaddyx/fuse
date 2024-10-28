<?php

declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource\Pages;


use Filament\Resources\Pages\ViewRecord;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;

class ViewUser extends ViewRecord
{
    public static function getResource(): string
    {
        return UserResource::class;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->icon('tabler-pencil'),
            Actions\DeleteAction::make()
                ->icon('tabler-trash')
                ->visible(fn(Model $record): bool => auth()->user()->can('delete_user') && $record->companies->isEmpty()),
        ];
    }
}
