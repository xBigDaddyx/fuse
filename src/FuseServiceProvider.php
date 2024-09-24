<?php

namespace Xbigdaddyx\Fuse;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Livewire\Livewire;
use Vcian\Pulse\PulseActiveSessions\Livewire\PulseActiveSessions;
use Xbigdaddyx\Fuse\Domain\System\Filament\Widgets\PulseSchedule;
use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\PulseActiveSessionsCard;
use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\UserStats;
use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\UserSummaryUnverifiedChart;
use Xbigdaddyx\Fuse\Domain\User\Filament\Widgets\UserSummaryVerifiedChart;

class FuseServiceProvider extends PackageServiceProvider
{

    public static string $name = 'fuse';

    public static string $viewNamespace = 'fuse';

    public function configurePackage(Package $package): void
    {
        /*
             * This class is a Package Service Provider
             *
             * More info: https://github.com/spatie/laravel-package-tools
             */
        $package->name(static::$name)

            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('xbigdaddyx/fuse');
            })
            ->hasViews(static::$viewNamespace);

        $configFileName = $package->shortName();
        if (file_exists($package->basePath("/../routes/web.php"))) {
            $package->hasRoutes("web");
        }
        if (file_exists($package->basePath("/../routes/api.php"))) {
            $package->hasRoutes("api");
        }

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }
    protected function getCommands(): array
    {
        return [
            // ChangeIssueStatus::class,
            // CheckIssueStatus::class,
        ];
    }
    protected function getMigrations(): array
    {
        return [
            '2024_04_24_000001_add_user_social_provider_table',
            '2024_04_24_000002_update_passwords_field_to_be_nullable',
            '2024_05_07_000003_add_two_factor_auth_columns',
            '2024_08_29_084314_create_permission_tables',
            '2024_08_30_161446_add_avatar_url_column_to_users_table',
            '2024_08_30_213816_create_pulse_tables',
            '2024_09_02_214855_create_companies_table',
            '2024_09_02_214931_create_user_company_table',
            '2024_09_03_131106_add_company_id_to_users_table',
            '2024_09_05_105711_add_additional_column_to_user_company_table',
            '2024_09_05_135517_add_personal_information_to_users_table',
            '2024_09_06_082434_create_connected_accounts_table',
            '2024_09_06_082435_modify_users_table_nullable_password',
            '2024_09_06_100207_create_activity_log_table',
            '2024_09_06_100208_add_event_column_to_activity_log_table',
            '2024_09_06_100209_add_batch_uuid_column_to_activity_log_table',
            '2024_09_09_085548_create_panel_table',
            '2024_09_09_085549_create_user_panel_table'
        ];
    }
    public function packageRegistered(): void
    {
        //$this->app->bind('VerificationRepository', \Xbigdaddyx\Fuse\Repositories\VerificationRepository::class);
        //$this->app->bind('SearchRepository', \Xbigdaddyx\Fuse\Repositories\SearchRepository::class);
        // $this->app->register(FuseEventServiceProvider::class);
        //$this->app->reqister(EventServiceProvider::class);
        //$this->register(EventServiceProvider::class);
        // $this->app->register(EventServiceProvider::class);
    }

    public function packageBooted(): void
    {
        $this->publishes([__DIR__ . '/../assets' => public_path('vendor/xbigdaddyx/assets')], 'fuse-assets');
        //Event::listen(CartonBoxStatusUpdated::class, CartonBoxStatusListener::class);
        // Event::listen(IssueCreatedEvent::class, SendIssueCreatedNotification::class);
        // Event::listen(IssuePendingEvent::class, SendIssuePendingNotification::class);
        // Event::listen(IssueResolvedEvent::class, SendIssueResolvedNotification::class);
        // Event::listen(FuseIssueCreatedEvent::class, SendFuseIssueCreatedNotification::class);
        // Event::listen(FuseCorrectionCreatedEvent::class, SendFuseCorrectionCreatedNotification::class);
        // Event::listen(CorrectionRejectedEvent::class, SendCorrectionRejectedNotification::class);
        // Event::listen(CorrectionApprovedEvent::class, SendCorrectionApprovedNotification::class);
        // Event::listen(CorrectionCreatedEvent::class, SendCorrectionCreatedNotification::class);
        // $this->callAfterResolving(BladeCompiler::class, function () {

        if (class_exists(Livewire::class)) {
            Livewire::component('user-summary-verified-chart', UserSummaryVerifiedChart::class);
            Livewire::component('user-summary-unverified-chart', UserSummaryUnverifiedChart::class);
            Livewire::component('xbigdaddyx.fuse.domain.system.filament.widgets.pulse-schedule', PulseSchedule::class);
            Livewire::component('user-stats', UserStats::class);
        }

        // Gate::policy(Issue::class, IssuePolicy::class);
        // Gate::policy(Area::class, AreaPolicy::class);
        // Gate::policy(Resolution::class, ResolutionPolicy::class);
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName(),

        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        // if (app()->runningInConsole()) {
        //     foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
        //         $this->publishes([
        //             $file->getRealPath() => base_path("stubs/Fuse/{$file->getFilename()}"),
        //         ], 'Fuse-stubs');
        //     }
        // }

        // Testing
        // Testable::mixin(new TestsApproval());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'xbigdaddyx/fuse';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // Css::make('fuse-theme', __DIR__ . '/../resources/dist/filament/fuse-theme.css'),
            // Css::make('fuse-style', __DIR__ . '/../resources/dist/fuse-theme.css'),
            // // AlpineComponent::make('filament-approvals', __DIR__ . '/../resources/dist/components/filament-approvals.js'),
            // Css::make('Fuse-styles', __DIR__ . '/../resources/dist/Fuse.css'),
            // Js::make('Fuse-scripts', __DIR__ . '/../resources/dist/Fuse.js'),
        ];
    }

    protected function getIcons(): array
    {
        return [];
    }


    protected function getRoutes(): array
    {
        return [];
    }


    protected function getScriptData(): array
    {
        return [];
    }
}
