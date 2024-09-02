<?php

namespace Xbigdaddyx\Fuse\Domain\Company\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'short_name',
        'name',
        'address',
        'logo'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_company');
    }
}
