<?php

namespace Xbigdaddyx\Fuse\Domain\Company\Filament\Resources;

use Filament\Actions\Action;
use Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource\Pages;
use Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource\RelationManagers;
use Xbigdaddyx\Fuse\Domain\Company\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    public static function getGloballySearchableAttributes(): array
    {
            return ['short_name', 'name', 'address'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
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
        return $record->name . ' (' . $record->short_name . ')';
    }
    public static function getNavigationLabel(): string
    {
        return trans('fuse::fuse.resource.company.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('fuse::fuse.resource.company.label');
    }

    public static function getLabel(): string
    {
        return trans('fuse::fuse.resource.company.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('fuse::fuse.resource.company.group');
    }

    public function getTitle(): string
    {
        return trans('fuse::fuse.resource.company.title.resource');
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('short_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('address')
                    ->columnSpanFull(),
                    Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->avatar()
                            ->downloadable()
                            ->openable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

    Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('logo')
                    ->circular()
                    ->grow(false),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold),
                    Tables\Columns\TextColumn::make('short_name')

                    ->iconColor('secondary')
                    ->icon('heroicon-o-identification'),

                    ]),

                ]),
                Tables\Columns\Layout\Panel::make([

                    Tables\Columns\TextColumn::make('address')
                    ->iconColor('secondary')
                    ->icon('heroicon-o-document-text')
                    ->html()


                ])->collapsible(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->visible(fn ():bool=>auth()->user()->can('viewAny_company')),
                Tables\Actions\EditAction::make()
                ->visible(fn ():bool=>auth()->user()->can('update_company')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn ():bool=>auth()->user()->can('delete_bulk_company')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => CompanyResource\Pages\ListCompanies::route('/'),
            'create' => CompanyResource\Pages\CreateCompany::route('/create'),
            'view' => CompanyResource\Pages\ViewCompany::route('/{record}'),
            'edit' => CompanyResource\Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
