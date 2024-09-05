<?php

namespace Xbigdaddyx\Fuse\Domain\User\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Xbigdaddyx\Fuse\Domain\Company\Models\Company;

class UserSummaryVerifiedChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'userSummaryVerifiedChart';
    protected int | string | array $columnSpan = 6;
    protected static ?int $sort = 2;
    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'User Summary (Verified)';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $trend =  Trend::query(
            User::query()
            ->verified()
            )
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Users Verified',
                    'data' => $trend->pluck('aggregate'),
                ],
            ],
            'xaxis' => [
                'categories' =>$trend->pluck('date'),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
        ];
    }
}
