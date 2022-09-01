<?php

namespace App\Models\Role;

use App\Data\Acl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;
    use LogsActivity;

    protected string $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Check whether current role is superuser
     * @return bool
     */
    public function isSuperuser(): bool
    {
        return $this->name === Acl::ROLE_SUPERUSER;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn($eventName) => "You have {$eventName} role")
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->dontSubmitEmptyLogs()
            ->useLogName('role');
    }
}
