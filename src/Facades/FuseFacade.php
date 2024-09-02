<?php

namespace Xbigdaddyx\Fuse\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VendorName\Skeleton\Skeleton
 */
class FuseFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Xbigdaddyx\Fuse\Fuse::class;
    }
}
