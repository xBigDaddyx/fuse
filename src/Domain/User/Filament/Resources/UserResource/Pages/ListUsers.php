<?php

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource\Pages;


use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource;
use Filament\Resources\Components\Tab;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;
use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\UserStats;
use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\UserSummaryVerifiedChart;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
    protected function getHeaderWidgets(): array
    {
        return [
            UserStats::class,
        ];
    }
    public function getTabs(): array
    {
        if (config('fuse.have_tenant')) {
            return [
                'all' => Tab::make(),
                'verified' => Tab::make()
                    ->badge(User::query()->verified()->where('company_id', Filament::getTenant()->id)->count())
                    ->badgeColor('success')
                    ->icon('heroicon-m-check-badge')
                    ->iconPosition(IconPosition::Before)
                    ->modifyQueryUsing(fn(Builder $query) => $query->verified()),
                'unverified' => Tab::make()
                    ->badge(User::query()->unverified()->where('company_id', Filament::getTenant()->id)->count())
                    ->badgeColor('danger')
                    ->icon('heroicon-m-x-circle')
                    ->iconPosition(IconPosition::Before)
                    ->modifyQueryUsing(fn(Builder $query) => $query->unverified()),
            ];
        }
        return [
            'all' => Tab::make(),
            'verified' => Tab::make()
                ->badge(User::query()->verified())
                ->badgeColor('success')
                ->icon('heroicon-m-check-badge')
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(fn(Builder $query) => $query->verified()->count()),
            'unverified' => Tab::make()
                ->badge(User::query()->unverified())
                ->badgeColor('danger')
                ->icon('heroicon-m-x-circle')
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(fn(Builder $query) => $query->unverified()),
        ];
    }
    public function getTitle(): string
    {
        return trans('fuse::fuse.resource.user.title.list');
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
