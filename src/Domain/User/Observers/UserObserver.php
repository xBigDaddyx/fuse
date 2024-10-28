<?php

namespace Xbigdaddyx\Fuse\Domain\User\Observers;

use Xbigdaddyx\Fuse\Domain\Company\Models\Company;
use Xbigdaddyx\Fuse\Domain\System\Models\Panel;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $company = Company::where('is_default', true)->first();
        if (!empty($panel)) {
            $user->companies()->attach($company->id);
        }

        $panel = Panel::where('is_default', true)->first();
        if (!empty($panel)) {
            $user->panels()->attach($panel->id);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // ...
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // ...
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        // ...
    }

    /**
     * Handle the User "forceDeleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // ...
    }
}
