<?php

namespace Xbigdaddyx\Fuse\Domain\System\Filament\Pages;

use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\UserStats;
use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\UserSummaryUnverifiedChart;
use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\UserSummaryVerifiedChart;

class UserDashboard extends \Filament\Pages\Dashboard
{
    protected static string $routePath = 'user';
    protected static ?string $title = 'User Summary';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    public function getColumns(): int|string|array
    {
        return 12;
    }



    public function getWidgets(): array
    {
        return [
            UserStats::class,
            UserSummaryVerifiedChart::class,
            UserSummaryUnverifiedChart::class,

        ];
    }
}
