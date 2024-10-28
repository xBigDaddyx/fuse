<?php

namespace Xbigdaddyx\Fuse\Domain\Company\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\HasAvatar;
use Xbigdaddyx\Falcon\Traits\HasInventories;
use Xbigdaddyx\Fuse\Domain\Company\Traits\HasProfileLogo;
use Xbigdaddyx\Fuse\Domain\User\Models\User;
use Xbigdaddyx\Fuse\Domain\User\Models\UserCompany;

class Company extends Model implements HasAvatar
{
    use HasFactory, HasProfileLogo, HasInventories;
    protected $fillable = [
        'short_name',
        'name',
        'address',
        'logo'
    ];
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->logo_url;
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_company')->withPivot(['employee_id', 'department', 'job_title'])->withTimestamps()->using(UserCompany::class);
    }
}
