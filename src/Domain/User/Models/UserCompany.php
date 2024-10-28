<?php

namespace Xbigdaddyx\Fuse\Domain\User\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Xbigdaddyx\Fuse\Domain\Company\Models\Company;
use Xbigdaddyx\Fuse\Domain\User\Models\User;

class UserCompany extends Pivot
{
    protected $table = 'user_company';
    protected $fillable = [
        'company_id',
        'user_id',
        'created_at',
        'updated_at',
        'employee_id',
        'department',
        'job_title'
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->employee_id = '-';
            $model->department = '-';
            $model->job_title = 'User';
        });
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
