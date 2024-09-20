<?php

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource\RelationManagers;

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
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PanelsRelationManager extends RelationManager
{
    protected static string $relationship = 'panels';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('panel_path')
            ->description('Assigned panel to this user.')
            ->columns([
                Split::make([
                    Tables\Columns\ImageColumn::make('logo')
                    ->grow(false),
                    Stack::make([
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
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->visible(fn ():bool=>auth()->user()->can('create_panel')),
                Tables\Actions\AttachAction::make()
                ->visible(fn ():bool=>auth()->user()->can('attach_panel')),


            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->visible(fn ():bool=>auth()->user()->can('update_panel') || auth()->user()->can('edit_panel')),
                Tables\Actions\DetachAction::make()
                ->visible(fn ():bool=>auth()->user()->can('detach_panel')),
                Tables\Actions\DeleteAction::make()
                ->visible(fn ():bool=>auth()->user()->can('delete_panel')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn ():bool=>auth()->user()->can('delete_bulk_panel')),
                ]),
            ]);
    }
}
