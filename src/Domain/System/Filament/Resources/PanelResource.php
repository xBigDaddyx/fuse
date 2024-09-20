<?php

namespace Xbigdaddyx\Fuse\Domain\System\Filament\Resources;

use Filament\Actions\Action;
use Xbigdaddyx\Fuse\Domain\Panel\Filament\Resources\PanelResource\Pages;
use Xbigdaddyx\Fuse\Domain\Panel\Filament\Resources\PanelResource\RelationManagers;
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
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Xbigdaddyx\Fuse\Domain\System\Models\Panel;

class PanelResource extends Resource
{
    protected static ?string $model = Panel::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    public static function getGloballySearchableAttributes(): array
    {
            return ['description', 'name', 'registered_panel_id'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Description' => $record->description,
        ];
    }
    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            // Action::make('edit')
            //     ->url(static::getUrl('edit', ['record' => $record]), shouldOpenInNewTab: true),
            // Action::make('view')
            //     ->url(static::getUrl('view', ['record' => $record])),
        ];
    }
    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->name . ' (' . $record->registered_panel_id . ')';
    }
    public static function getNavigationLabel(): string
    {
        return trans('fuse::fuse.resource.panel.label');
    }

    public static function getPluralLabel(): string
    {
        return trans('fuse::fuse.resource.panel.label');
    }

    public static function getLabel(): string
    {
        return trans('fuse::fuse.resource.panel.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('fuse::fuse.resource.panel.group');
    }

    public function getTitle(): string
    {
        return trans('fuse::fuse.resource.panel.title.resource');
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('logo')
                        ->label('logo')
                        ->directory('logos')
                        ->columnSpanFull()
                        ->getUploadedFileNameForStorageUsing(
                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                ->prepend(Auth::user()->name . '-'),
                        )
                        ->downloadable()
                        ->image()
                        ->imageEditor()
                        ->grow(false),
                        Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                Forms\Components\TextInput::make('panel_path')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('registered_panel_id')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\RichEditor::make('description')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('logo')
                    ->grow(false),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold),

                        Tables\Columns\TextColumn::make('description')
                        ->iconColor('secondary')
                        ->icon('heroicon-o-document-text')
                        ->html()
                    ]),

                ]),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->visible(fn ():bool=>auth()->user()->can('viewAny_panel')),
                Tables\Actions\EditAction::make()
                ->visible(fn ():bool=>auth()->user()->can('update_panel')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn ():bool=>auth()->user()->can('delete_bulk_panel')),
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
            'index' => PanelResource\Pages\ManagePanels::route('/'),

        ];
    }
}
