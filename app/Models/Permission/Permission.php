<?php

namespace App\Models\Permission;

use App\Data\Acl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class Permission.
 *
 * @package namespace App\Models;
 */
class Permission extends \Spatie\Permission\Models\Permission
{

    use HasFactory;
    use LogsActivity;
    use PermissionAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
    ];

    protected string $guard_name = 'sanctum';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn($eventName) => "You have {$eventName} permission")
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->dontSubmitEmptyLogs()
            ->useLogName('permission');
    }
}
