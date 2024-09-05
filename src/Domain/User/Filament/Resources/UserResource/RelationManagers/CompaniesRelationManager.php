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

class CompaniesRelationManager extends RelationManager
{
    protected static string $relationship = 'companies';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('short_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('short_name')
            ->description('Assigned company to this user.')
            ->columns([
                Split::make([
                    Tables\Columns\ImageColumn::make('logo')
                    ->circular()
                    ->grow(false),
                    Stack::make([
                        Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold),

                        Tables\Columns\TextColumn::make('address')
                        ->iconColor('secondary')
                        ->icon('heroicon-o-document-text')
                        ->html()
                    ]),

                ]),
                Panel::make([
                    Tables\Columns\TextColumn::make('employee_id')

                    ->iconColor('secondary')
                    ->icon('heroicon-o-identification'),
                    Tables\Columns\TextColumn::make('department')

                    ->iconColor('secondary')
                    ->icon('heroicon-o-briefcase'),
                    Tables\Columns\TextColumn::make('job_title')
                    ->iconColor('secondary')
                    ->icon('heroicon-o-tag'),


                ])->collapsible(),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->visible(fn ():bool=>auth()->user()->can('create_company')),
                Tables\Actions\AttachAction::make()
                ->visible(fn ():bool=>auth()->user()->can('attach_company'))
                ->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    Group::make([
                        Forms\Components\TextInput::make('employee_id')
                        ->prefixIcon('heroicon-m-identification')
                        ->prefixIconColor('primary')
                        ->required(),
                        Forms\Components\TextInput::make('department')
                        ->prefixIcon('heroicon-m-briefcase')
                        ->prefixIconColor('primary')
                        ->required(),
                        Forms\Components\TextInput::make('job_title')
                        ->columnSpanFull()
                        ->prefixIcon('heroicon-m-document-text')
                        ->prefixIconColor('primary'),
                    ])->columns(2),

                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->visible(fn ():bool=>auth()->user()->can('update_company') || auth()->user()->can('edit_company')),
                Tables\Actions\DetachAction::make()
                ->visible(fn ():bool=>auth()->user()->can('detach_company')),
                Tables\Actions\DeleteAction::make()
                ->visible(fn ():bool=>auth()->user()->can('delete_company')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn ():bool=>auth()->user()->can('delete_bulk_company')),
                ]),
            ]);
    }
}
