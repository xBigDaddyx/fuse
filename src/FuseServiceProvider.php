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
                //
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
                    Livewire::component('xbigdaddyx.fuse.domain.system.filament.widgets.pulse-schedule',PulseSchedule::class);
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
                Css::make('fuse-theme', __DIR__ . '/../resources/dist/filament/fuse-theme.css'),
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
