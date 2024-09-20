<?php
namespace Xbigdaddyx\Fuse\Domain\User\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Xbigdaddyx\Fuse\Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Xbigdaddyx\Fuse\Domain\User\Traits\HasProfileAvatar;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Xbigdaddyx\Fuse\Domain\System\Models\Panel as ModelsPanel;
use Devdojo\Auth\Models\User as AuthUser;

class User extends AuthUser implements FilamentUser,HasTenants, HasAvatar, MustVerifyEmail
{
    use HasRoles,Notifiable,HasProfileAvatar,LogsActivity;
    public function canAccessPanel(Panel $panel): bool
    {
        //return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
        $panels = ModelsPanel::all();
        foreach ($panels as $key => $value) {
            $user_panels = auth()->user()->panels;
            if($user_panels->contains('registered_panel_id',$value->registered_panel_id)){
                return true;
            }

        }
        return false;
        //return $this->hasVerifiedEmail();
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'email','password','avatar_url','roles','email_verified_at'])->logOnlyDirty();
    }
    protected $hidden = [
        'remember_token',
        'password'
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }
    public function canImpersonate()
    {
        return auth()->user()->email === 'faisal.yusuf@hoplun.com';
    }
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'user_company')->withPivot(['employee_id','department','job_title'])->withTimestamps();
    }
    public function company():BelongsTo{
        return $this->belongsTo(Company::class);
    }
    public function userCompany():HasMany{
        return $this->hasMany(UserCompany::class);
    }
    public function getTenants(Panel $panel): Collection
    {
        return $this->companies;
    }
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->companies()->whereKey($tenant)->exists();
    }
    public function scopeVerified(Builder $query): void
    {
        $query->where('email_verified_at','!=', null);
    }
    public function scopeUnverified(Builder $query): void
    {
        $query->where('email_verified_at', null);
    }
    public function panels():BelongsToMany{
        return $this->belongsToMany(ModelsPanel::class,'user_panel');
    }


}
