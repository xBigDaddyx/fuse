<?php

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources;

use Filament\Forms;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Panel;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource\Pages\ViewUser;
use Filament\Forms\Components\Grid;
use Livewire\Component;
use Xbigdaddyx\Fuse\Domain\User\Filament\Fields\PermissionGroup;
use Xbigdaddyx\Fuse\Domain\User\Filament\Fields\RoleSelect;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Split as ComponentsSplit;
use Filament\Tables\Columns\Summarizers\Count;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Xbigdaddyx\Fuse\Domain\Company\Models\Company;
use Rmsramos\Activitylog\Actions\ActivityLogTimelineTableAction;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 9;
    protected static bool $isScopedToTenant = true;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    public static function getGlobalSearchEloquentQuery(): Builder
{
    return parent::getGlobalSearchEloquentQuery()->with(['companies']);
}
    public static function getGloballySearchableAttributes(): array
    {
            return [ 'name', 'email'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {

        return [
            'Email' => $record->email,
            'Phone' => $record->phone,
            'Address' => $record->address,

        ];
    }
    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Action::make('edit')
                ->url(static::getUrl('edit', ['record' => $record]), shouldOpenInNewTab: true),
            Action::make('view')
                ->url(static::getUrl('view', ['record' => $record])),
        ];
    }
    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->name;
    }
    public static function getNavigationLabel(): string
    {
        return trans('fuse::fuse.resource.user.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('fuse::fuse.resource.user.label');
    }

    public static function getLabel(): string
    {
        return trans('fuse::fuse.resource.user.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('fuse::fuse.resource.user.group');
    }

    public function getTitle(): string
    {
        return trans('fuse::fuse.resource.user.title.resource');
    }

    public static function form(Form $form): Form
    {

        $rows = [


            Grid::make()
                ->schema(
                    static fn(Component $livewire) => $livewire instanceof ViewUser
                        ? [

                            static::detailsSection(),
                            Section::make('Credential')
                                ->schema([
                                    TextInput::make('email')
                                    ->prefixIcon('heroicon-m-envelope')
    ->prefixIconColor('primary')
                                        ->label(__('fuse::fuse.resource.user.email'))
                                        ->validationAttribute(__('fuse::fuse.resource.user.email'))
                                        ->required()
                                        ->email(),
                                    TextInput::make('password')
                                    ->prefixIcon('heroicon-m-key')
                                    ->prefixIconColor('primary')
                                    ->autocomplete(false)
                                        ->hiddenOn('edit')
                                        ->label(__('fuse::fuse.resource.user.password'))
                                        ->password()
                                        ->maxLength(255)
                                        ->dehydrateStateUsing(static function ($state, $record) use ($form) {
                                            return !empty($state)
                                                ? Hash::make($state)
                                                : $record->password;
                                        }),

                                ]),
                            Section::make(__('fuse::fuse.resource.user.sections.permissions'))
                                ->description(__('fuse::fuse.resource.user.messages.permissions_view'))
                                ->schema([
                                    PermissionGroup::make('permissions')
                                        ->label(__('fuse::fuse.resource.user.permissions'))
                                        ->validationAttribute(
                                            __('fuse::fuse.resource.user.permissions'),
                                        )
                                        ->resolveStateUsing(
                                            static fn($record) => $record->getAllPermissions()->pluck('id')->all(),
                                        ),
                                ]),

                        ] : [

                            static::detailsSection(),
                            Section::make('Credential')
                                ->schema([
                                    TextInput::make('email')
                                    ->prefixIcon('heroicon-m-envelope')
                                    ->prefixIconColor('primary')
                                        ->label(__('fuse::fuse.resource.user.email'))
                                        ->validationAttribute(__('fuse::fuse.resource.user.email'))
                                        ->required()
                                        ->email(),
                                    TextInput::make('password')
                                    ->prefixIcon('heroicon-m-key')
                                    ->prefixIconColor('primary')
                                    ->autocomplete(false)
                                        ->hiddenOn('edit')
                                        ->label(__('fuse::fuse.resource.user.password'))
                                        ->password()
                                        ->maxLength(255)
                                        ->dehydrateStateUsing(static function ($state, $record) use ($form) {
                                            return !empty($state)
                                                ? Hash::make($state)
                                                : $record->password;
                                        }),

                                ]),
//                                 Section::make('Companies')
//                                 ->schema([
// Repeater::make('userCompany')
// ->relationship()
//     ->schema([
//         Select::make('company_id')
//         ->relationship('company','name')
//         ->required(),
//         Select::make('user_id')
//         ->relationship('user','name')
//         ->required(),
//         Forms\Components\TextInput::make('employee_id')->required(),
//         Forms\Components\TextInput::make('department')->required(),
//         Forms\Components\TextInput::make('job_title'),
//     ])
//     ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
//         $data['user_id'] = auth()->id();

//         return $data;
//     })
//     ->collapsible()
//     ->reorderableWithDragAndDrop(false)
//     ->reorderable(false)
//     ->addActionLabel('Assign companies')
//     ->columns(2)
//                                 ]),
                            // Section::make(__('fuse::fuse.resource.user.sections.permissions'))
                            //     ->description(__('fuse::fuse.resource.user.messages.permissions_create'))
                            //     ->schema([
                            //         PermissionGroup::make('permissions')
                            //             ->label(__('fuse::fuse.resource.user.permissions'))
                            //             ->validationAttribute(
                            //                 __('fuse::fuse.resource.user.permissions'),
                            //             ),
                            //     ]),

                        ],
                )
                ->columns(1),

        ];
        $form->schema($rows);
        return $form;
    }
    protected static function detailsSectionSchema(): array
    {
        return [
            ComponentsSplit::make([
                Group::make([
                    FileUpload::make('avatar_url')
                        ->label('Avatar')
                        ->directory('avatars')
                        ->getUploadedFileNameForStorageUsing(
                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                ->prepend(Auth::user()->name . '-'),
                        )
                        ->downloadable()
                        ->image()
                        ->avatar()
                        ->imageEditor()
                        ->circleCropper()
                        ->grow(false),
                ])->grow(false),
                Group::make([

                        TextInput::make('name')
                        ->prefixIcon('heroicon-m-pencil')
                        ->prefixIconColor('primary')
                            ->label(__('fuse::fuse.resource.user.name'))
                            ->required(),
                            TextInput::make('phone')
                            ->prefixIcon('heroicon-m-phone')
                            ->prefixIconColor('primary')
                            ->tel()
                            ->label(__('fuse::fuse.resource.user.phone')),
                            Radio::make('gender')

                            ->label(__('fuse::fuse.resource.user.gender'))
                            ->options([
                                'f' => 'Female',
                                'm' => 'Male',
                            ]),
                        RoleSelect::make('role')
                        ->prefixIcon('heroicon-m-check-badge')
                        ->prefixIconColor('primary')
                            ->label(__('fuse::fuse.resource.user.role'))
                            ->validationAttribute(__('fuse::fuse.resource.user.role')),
                            RichEditor::make('address')

                            ->columnSpanFull()
                            ->label(__('fuse::fuse.resource.user.address')),

                ])->columns(2)
            ]),



        ];
    }
    protected static function detailsSection(): Section
    {
        return Section::make(__('fuse::fuse.resource.user.sections.user_details'))
        ->description(__('fuse::fuse.resource.user.sections.user_details_description'))
            ->schema(static::detailsSectionSchema());
    }
    // protected static function evaluateMinDate(Component $livewire): null|Carbon|CarbonImmutable
    // {
    //     if ($livewire instanceof CreateUser) {
    //         return now();
    //     }

    //     return null;
    // }
    public static function table(Table $table): Table
    {
        if (class_exists(\STS\FilamentImpersonate\Tables\Actions\Impersonate::class) && config('filament-users.impersonate')) {
            $table->actions([Impersonate::make('impersonate')]);
        }
        if (config('fuse.have_tenant')) {
            $table->columns([
                TextColumn::make('employee_id'),
                TextColumn::make('department'),
                TextColumn::make('companies.short_name')
                    ->color('info')
                    ->badge(),
            ]);
        }
        $table
            ->columns([

                Split::make([

                    ImageColumn::make('avatar_url')
                        ->label('Avatar')
                        ->grow(false)
                        ->circular(),


                    TextColumn::make('name')
                        ->sortable()
                        ->searchable()
                        ->grow(false)
                        ->label(trans('fuse::fuse.resource.user.name')),
                    IconColumn::make('email_verified_at')

                        ->boolean()
                        ->sortable()
                        ->searchable()
                        ->label(trans('fuse::fuse.resource.user.email_verified_at')),







                ]),
                Panel::make([
                    TextColumn::make('email')
                    ->color('primary')
                        ->icon('heroicon-o-envelope')
                        ->sortable()
                        ->searchable()
                        ->label(trans('fuse::fuse.resource.user.email'))
                        ->grow(false),
                    TextColumn::make('phone')
                        ->icon('heroicon-o-phone')
                        ->color('secondary')
                        ->sortable()
                        ->grow(false),
                        TextColumn::make('gender')
                        ->formatStateUsing(function (string $state){
                            if($state === 'm'){
                                return "Male";
                            }
                            return "Female";
                        })
                        ->icon('heroicon-o-user-group')

                        ->sortable()
                        ->grow(false),
                        TextColumn::make('address')
                        ->icon('heroicon-o-building-storefront')

                        ->sortable()
                        ->grow(false),
                    TextColumn::make('roles.name')
                        ->icon('heroicon-o-star')
                        ->grow(false),
                    // TextColumn::make('created_at')
                    //     ->icon('heroicon-o-calendar')
                    //     ->toggleable(isToggledHiddenByDefault: true)
                    //     ->label(trans('fuse::fuse.resource.user.created_at'))
                    //     ->dateTime('M j, Y')
                    //     ->sortable(),
                    // TextColumn::make('updated_at')
                    //     ->icon('heroicon-o-calendar')
                    //     ->toggleable(isToggledHiddenByDefault: true)
                    //     ->label(trans('fuse::fuse.resource.user.updated_at'))
                    //     ->dateTime('M j, Y')
                    //     ->sortable(),
                ])->collapsible(),
                // TextColumn::make('id')
                // ->toggleable(isToggledHiddenByDefault: true)
                // ->sortable()
                // ->label(trans('fuse::fuse.resource.user.id')),




            ])

            ->contentGrid([
                'md' => 2,
                'xl' => 4,
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label(trans('fuse::fuse.resource.user.verified'))
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('unverified')
                    ->label(trans('fuse::fuse.resource.user.unverified'))
                    ->query(fn(Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->actions([
                Impersonate::make(),
                ActivityLogTimelineTableAction::make('Activities')
                ->timelineIcons([
                    'created' => 'heroicon-m-check-badge',
                    'updated' => 'heroicon-m-pencil-square',
                ])
                ->timelineIconColors([
                    'created' => 'info',
                    'updated' => 'warning',
                ])
                ->withRelations(['roles']),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()

            ]);
        return $table;
    }
    public static function getRelations(): array
    {
        return [
            UserResource\RelationManagers\CompaniesRelationManager::class,
            UserResource\RelationManagers\PanelsRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => UserResource\Pages\ListUsers::route('/'),
            // 'create' => CreateUser::route('/create'),
            'edit' => UserResource\Pages\EditUser::route('/{record}/edit'),
            'view' =>  UserResource\Pages\ViewUser::route('/{record}'),
        ];
    }
}
