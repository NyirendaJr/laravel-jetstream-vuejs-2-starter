<?php

namespace App\Models\Permission;

use App\Data\Acl;

trait PermissionAttributes
{
    /**
     * To exclude permission management from the list
     *
     * @param $query
     * @return mixed
     */
    public function scopeAllowed($query): mixed
    {
        return $query
            ->where('name', '!=', Acl::PERMISSION_SYNC_PERMISSION)
            ->where('name', '!=', Acl::PERMISSION_UPDATE_ROLE_PERMISSION)
            ->where('name', '!=', Acl::PERMISSION_VIEW_MENU_PERMISSION)
            ->where('name', '!=', Acl::PERMISSION_VIEW_MENU_PERMISSION)
            ->where('name', '!=', Acl::PERMISSION_VIEW_MENU_ROLES);
    }
}
