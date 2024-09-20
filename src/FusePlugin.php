<?php

namespace Xbigdaddyx\Fuse;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Xbigdaddyx\Fuse\Domain\Company\Filament\Resources\CompanyResource;
use Xbigdaddyx\Fuse\Domain\System\Filament\Resources\PanelResource;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\UserResource;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\RoleResource;
use Xbigdaddyx\Fuse\Domain\User\Filament\Resources\PermissionResource;
class FusePlugin implements Plugin
{

    public function getId(): string
    {
        return 'Fuse';
    }

    public function register(Panel $panel): void
    {

        $panel->pages([
            // EditCompanyProfile::class,
            // RegisterCompany::class,

        ])
            ->resources([
                UserResource::class,
                RoleResource::class,
                PermissionResource::class,
                CompanyResource::class,
                PanelResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
