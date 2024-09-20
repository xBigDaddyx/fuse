<?php

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\RoleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\PermissionResource;

class PermissionsRelationManager extends RelationManager{
    protected static string $relationship = 'permissions';
    public function form(Form $form): Form{
        return PermissionResource::form($form);
    }
    public function table(Table $table): Table{
        return PermissionResource::table($table)
        ->recordTitleAttribute('name')
        ->description('Assigned permissions to this role.')
        ->headerActions([
            Tables\Actions\CreateAction::make(),
            Tables\Actions\AttachAction::make()
        ]);
    }
}
