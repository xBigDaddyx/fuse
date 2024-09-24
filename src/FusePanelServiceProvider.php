<?php

namespace Xbigdaddyx\Fuse;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Enums\MaxWidth;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Config;

class FusePanelServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        if (config('fuse.have_tenant')) {
            $panel
                ->tenantMenuItems([
                    'register' => MenuItem::make()->label('Register new company')
                        ->visible(fn(): bool => auth()->user()->hasRole('super-admin')),
                    'profile' => MenuItem::make()->label('Company profile'),
                ])

                // ->tenantMiddleware([
                //     ApplyTenantScopes::class,
                // ], isPersistent: true)
                //->tenantRoutePrefix('company')
                ->tenant(\Xbigdaddyx\Fuse\Domain\Company\Models\Company::class, 'short_name', 'company')
                // ->tenantRegistration(RegisterCompany::class)
                ->tenantProfile(\Xbigdaddyx\Fuse\Domain\System\Filament\Pages\EditCompanyProfile::class);
        }
        return $panel
            ->default()
            ->id('fuse')
            ->path('fuse')
            ->emailVerification()
            // ->profile(Domain\User\Filament\Pages\Auth\Profile::class)
            ->unsavedChangesAlerts()
            ->passwordReset()

            // ->viteTheme('resources/css/filament/fuse/theme.css')
            ->topNavigation()
            // ->spa()
            ->maxContentWidth(MaxWidth::Full)
            ->login()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->font('Poppins')
            ->sidebarCollapsibleOnDesktop()
            ->brandLogo(asset('vendor/xbigdaddyx/assets/teresa_fuse_full_logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('vendor/xbigdaddyx/assets/teresa_fuse_logo.png'))

            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
                    //If you are using tenancy need to check with the visible method where ->company() is the relation between the user and tenancy model as you called
                    ->visible(function (): bool {
                        return auth()->user()->company()->exists();
                    }),
            ])
            ->colors([
                'primary' => '#306E6D',
                'secondary' => '#F9B218'
            ])->plugins([

                \Rmsramos\Activitylog\ActivitylogPlugin::make()
                    ->navigationGroup('Settings')
                    ->navigationSort(3),
                \CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin::make()
                    ->highlighter(false),
                \ChrisReedIO\Socialment\SocialmentPlugin::make()
                    ->registerProvider('azure', 'fab-microsoft', 'Sign in with Microsoft'),
                \Xbigdaddyx\Fuse\FusePlugin::make(),
                \Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin::make(),
                \Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('My Profile')
                    ->setNavigationLabel('My Profile')
                    ->setNavigationGroup('Group Profile')
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    ->canAccess(fn() => auth()->user()->id === 1)
                    ->shouldRegisterNavigation(false)
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm()
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars', // image will be stored in 'storage/app/public/avatars
                        rules: 'mimes:jpeg,png|max:1024' //only accept jpeg and png files with a maximum size of 1MB
                    ),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'Xbigdaddyx\\Fuse\\Domain\\User\\Filament\\Resources')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'Xbigdaddyx\\Fuse\\Domain\\Company\\Filament\\Resources')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'Xbigdaddyx\\Fuse\\Domain\\System\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'Xbigdaddyx\\Fuse\\Domain\\User\\Filament\\Pages')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'Xbigdaddyx\\Fuse\\Domain\\Company\\Filament\\Pages')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'Xbigdaddyx\\Fuse\\Domain\\System\\Filament\\Pages')
            ->pages([
                Domain\System\Filament\Pages\PulseDashboard::class,
                Domain\System\Filament\Pages\UserDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'Xbigdaddyx\\Fuse\\Domain\\User\\Filament\\Widgets')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'Xbigdaddyx\\Fuse\\Domain\\Company\\Filament\\Widgets')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'Xbigdaddyx\\Fuse\\Domain\\System\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
