<?php

namespace App\Data;

use Illuminate\Support\Arr;

final class Acl
{

    /*
    |--------------------------------------------------------------------------
    | System Roles and Permissions
    |--------------------------------------------------------------------------
    |
    |
    */

    const ROLE_ADMIN = 'Admin';
    const ROLE_SUPERUSER = 'Superuser';

    // Permission Model
    const PERMISSION_SYNC_PERMISSION = 'sync_permission';

    // Role Model
    const PERMISSION_CREATE_ROLE = 'create_role';
    const PERMISSION_VIEW_ROLE = 'view_role';
    const PERMISSION_UPDATE_ROLE = 'update_role';
    const PERMISSION_DELETE_ROLE = 'delete_role';
    const PERMISSION_SYNC_ROLE = 'sync_role';
    const PERMISSION_VIEW_ROLE_DETAILS = 'view_role_details';

    // User Model
    const PERMISSION_CREATE_USER = 'create_user';
    const PERMISSION_VIEW_USER = 'view_user';
    const PERMISSION_UPDATE_USER = 'update_user';
    const PERMISSION_DELETE_USER = 'delete_user';
    const PERMISSION_RESET_USER_PASSWORD = 'reset_user_password';
    const PERMISSION_BLOCK_AND_UNBLOCK_USER = 'block_and_unblock_user';

    // User role
    const PERMISSION_CREATE_USER_ROLE = 'create_user_role';
    const PERMISSION_VIEW_USER_ROLE = 'view_user_role';
    const PERMISSION_UPDATE_USER_ROLE = 'update_user_role';
    const PERMISSION_DELETE_USER_ROLE = 'delete_user_role';

    // Role permissions
    const PERMISSION_CREATE_ROLE_PERMISSION = 'create_role_permission';
    const PERMISSION_VIEW_ROLE_PERMISSION = 'view_role_permission';
    const PERMISSION_UPDATE_ROLE_PERMISSION = 'update_role_permission';
    const PERMISSION_DELETE_ROLE_PERMISSION = 'delete_role_permission';

    // User permissions
    const PERMISSION_CREATE_USER_PERMISSION = 'create_user_permission';
    const PERMISSION_VIEW_USER_PERMISSION = 'view_user_permission';
    const PERMISSION_UPDATE_USER_PERMISSION = 'update_user_permission';
    const PERMISSION_DELETE_USER_PERMISSION = 'delete_user_permission';

    /*
    |--------------------------------------------------------------------------
    | Menu Permissions
    |--------------------------------------------------------------------------
    |
    |
    */
    const PERMISSION_VIEW_MENU_ROLES = 'view menu roles';
    const PERMISSION_VIEW_MENU_PERMISSION = 'view menu permissions';
    const PERMISSION_VIEW_MENU_USERS = 'view menu users';
    const PERMISSION_VIEW_MENU_ADMIN = 'view menu admin';
}
