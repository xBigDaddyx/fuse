<?php

namespace Xbigdaddyx\Fuse\Domain\System\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\HasAvatar;
use Xbigdaddyx\Fuse\Domain\Panel\Traits\HasProfileLogo;

class Panel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'registered_panel_id',
        'panel_path',
        'logo'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_panel');
    }
}
