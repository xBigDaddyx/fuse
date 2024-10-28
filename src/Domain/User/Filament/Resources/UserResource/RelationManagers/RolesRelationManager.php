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

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->description('Assigned roles to this user.')
            ->columns([
                Split::make([
                    Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->weight(FontWeight::Bold),

                        Tables\Columns\TextColumn::make('guard_name')
                            ->iconColor('warning')
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
                    ->visible(fn(): bool => auth()->user()->can('create_role')),
                Tables\Actions\AttachAction::make()
                    ->visible(fn(): bool => auth()->user()->can('attach_role')),


            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn(): bool => auth()->user()->can('update_role') || auth()->user()->can('edit_role')),
                Tables\Actions\DetachAction::make()
                    ->visible(fn(): bool => auth()->user()->can('detach_role')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn(): bool => auth()->user()->can('delete_role')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn(): bool => auth()->user()->can('delete_bulk_role')),
                ]),
            ]);
    }
}
