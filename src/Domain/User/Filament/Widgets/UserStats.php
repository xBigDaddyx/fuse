<?php
namespace Xbigdaddyx\Fuse\Domain\User\Filament\Widgets;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget as BaseWidget;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget\Stat;
use Filament\Facades\Filament;
use Flowframe\Trend\Trend;
use Xbigdaddyx\Fuse\Domain\Company\Models\Company;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

class UserStats extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $users = User::where('company_id',Filament::getTenant()->id);
        $companies = Company::all();
        if(config('fuse.have_tenant')){
            $unverified = User::unverified()->where('company_id',Filament::getTenant()->id)->count();
        }else{
            $unverified = User::unverified()->count();
        }

        return [
            Stat::make('Total Users', $users->count())->icon('heroicon-o-user')

                ->progress($users->count()/100*1000)
                ->progressBarColor('success')
                ->iconBackgroundColor('success')

                ->chartColor('success')
                ->iconPosition('start')
                ->description(Filament::getTenant()->name)
                ->descriptionIcon('heroicon-o-chevron-up', 'before')
                ->descriptionColor('success')
                ->iconColor('success'),
            Stat::make('Total Companies', $companies->count())->icon('heroicon-o-building-office')
                ->description('The companies in total')
                ->descriptionIcon('heroicon-o-chevron-up', 'before')
                ->descriptionColor('primary')
                ->iconColor('warning'),
            Stat::make('Total Unverified', $unverified)->icon('heroicon-o-check-badge')
                ->description(Filament::getTenant()->name)
                ->descriptionIcon('heroicon-o-chevron-down', 'before')
                ->descriptionColor('danger')
                ->iconColor('danger')
        ];
    }
}
