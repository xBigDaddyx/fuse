<?php declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Xbigdaddyx\Fuse\Domain\User\Filament\Fields\PermissionGroup;
class RoleResource extends Resource
{

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getModel(): string
    {
        return config('permission.models.role');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('name')
                    ->label(__('fuse::fuse.resource.role.name'))
                    ->validationAttribute(__('fuse::fuse.resource.role.name'))
                    ->required()
                    ->maxLength(255)
                    ->unique(config('permission.table_names.roles'), 'name', static fn ($record) => $record),
                // PermissionGroup::make('permissions')
                //     ->label(__('fuse::fuse.resource.role.permissions'))
                //     ->validationAttribute(__('fuse::fuse.resource.role.permissions')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
    ->rowIndex(),
                // TextColumn::make('id')
                //     ->label(__('fuse::fuse.resource.role.id'))
                //     ->sortable(),
                TextColumn::make('description')
                    ->label(__('fuse::fuse.resource.role.description'))
                    ->getStateUsing(static fn ($record) => __($record->name)),
                TextColumn::make('name')

                ->summarize(Count::make()->label('Total')->prefix('Roles : '))
                    ->label(__('fuse::fuse.resource.role.name'))
                    ->searchable(),
                    TextColumn::make('permissions')
                    ->getStateUsing(static fn ($record) => (string)$record->permissions()->count())
                    ->label(__('fuse::fuse.resource.role.permissions'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('fuse::fuse.resource.role.created_at'))
                    ->dateTime(),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => RoleResource\Pages\ListRoles::route('/'),
            'create' => RoleResource\Pages\CreateRole::route('/create'),
            'edit' => RoleResource\Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('fuse::fuse.resource.role.label');
    }

    public static function getPluralLabel(): string
    {
        return __('fuse::fuse.resource.role.label');
    }

    public static function getEloquentQuery(): Builder
    {
        $model = config('permission.models.role');

        return $model::query()->where('guard_name', '=', 'web');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('fuse::fuse.resource.role.group');
    }
    public static function getRelations(): array
    {
        return [
            RoleResource\RelationManagers\PermissionsRelationManager::class,
        ];
    }
}
