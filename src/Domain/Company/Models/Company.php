<?php

namespace Xbigdaddyx\Fuse\Domain\Company\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\HasAvatar;
use Xbigdaddyx\Fuse\Domain\Company\Traits\HasProfileLogo;

class Company extends Model implements HasAvatar
{
    use HasFactory, HasProfileLogo;
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
        return $this->belongsToMany(User::class, 'user_company');
    }
}
