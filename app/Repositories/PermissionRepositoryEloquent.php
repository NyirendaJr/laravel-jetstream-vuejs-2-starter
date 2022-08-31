<?php

namespace App\Repositories;

use App\Models\Permission;


class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}
