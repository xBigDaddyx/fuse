<?php
namespace Xbigdaddyx\Fuse;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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

class FusePanelServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->emailVerification()
        ->profile(Domain\User\Filament\Pages\Auth\Profile::class)
        ->unsavedChangesAlerts()
        ->passwordReset()
        ->viteTheme('vendor/xbigdaddyx/fuse/resources/css/filament/fuse-theme.css')
        // ->topNavigation()
        // ->spa()
        ->login()
        ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
        ->font('Poppins')
        ->sidebarCollapsibleOnDesktop()
        ->brandLogo(asset('storage/images/logo/teresa_fuse_full_logo.png'))
        ->brandLogoHeight('3rem')
        ->favicon(asset('storage/images/logo/teresa_fuse_logo.png'))
        ->colors([
            'primary' => '#306E6D','secondary'=>'#F9B218'
        ])->plugins([
            \Xbigdaddyx\Fuse\FusePlugin::make(),
        ])
        ->discoverResources(in: app_path('Filament/Resources'), for: 'Xbigdaddy\\Fuse\\Domain')
        ->discoverPages(in: app_path('Filament/Pages'), for: 'Xbigdaddy\\Fuse\\Domain')
        ->pages([
           Domain\System\Filament\Pages\Dashboard::class,
        ])
        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
