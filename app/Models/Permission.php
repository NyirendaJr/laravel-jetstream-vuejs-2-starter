<?php

namespace App\Models;

use App\Data\Acl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Permission.
 *
 * @package namespace App\Models;
 */
class Permission extends \Spatie\Permission\Models\Permission
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
    ];

    protected string $guard_name = 'sanctum';

    /**
     * To exclude permission management from the list
     *
     * @param $query
     * @return Builder
     */
    public function scopeAllowed($query)
    {
        return $query
            ->where('name', '!=', Acl::PERMISSION_SYNC_PERMISSION)
            ->where('name', '!=', Acl::PERMISSION_UPDATE_ROLE_PERMISSION)
            ->where('name', '!=', Acl::PERMISSION_VIEW_MENU_PERMISSION)
            ->where('name', '!=', Acl::PERMISSION_VIEW_MENU_PERMISSION)
            ->where('name', '!=', Acl::PERMISSION_VIEW_MENU_ROLES);
    }

}
