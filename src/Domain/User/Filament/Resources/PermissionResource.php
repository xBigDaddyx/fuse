<?php

declare(strict_types=1);

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources;



use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;

class PermissionResource extends Resource
{

    protected static ?string $model = Permission::class;
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public static function getModel(): string
    {
        return config('permission.models.permission');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                ->prefixIcon('heroicon-m-pencil')
                        ->prefixIconColor('primary')
                        ->helperText('example : view_xxxx')
                    ->label(__('fuse::fuse.resource.permission.name'))
                    ->validationAttribute(__('fuse::fuse.resource.permission.name'))
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        config('permission.table_names.permissions'),
                        'name',
                        static fn(?Permission $record): ?Permission => $record,
                    ),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->label(__('fuse::fuse.resource.permission.id'))
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('fuse::fuse.resource.permission.description'))
                    ->getStateUsing(static fn(Permission $record) => __($record->name)),
                TextColumn::make('name')

                    ->label(__('fuse::fuse.resource.permission.name'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('fuse::fuse.resource.permission.created_at'))
                    ->dateTime(),

            ])
            ->actions(
                [
                    EditAction::make()
                ]
            )
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => PermissionResource\Pages\ListPermissions::route('/'),
            'create' => PermissionResource\Pages\CreatePermission::route('/create'),
            'edit' => PermissionResource\Pages\EditPermission::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('fuse::fuse.resource.permission.label');
    }

    public static function getPluralLabel(): string
    {
        return __('fuse::fuse.resource.permission.label');
    }

    public static function getEloquentQuery(): Builder
    {
        return Permission::query()->where('guard_name', '=', 'web');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('fuse::fuse.resource.permission.group');
    }
}
