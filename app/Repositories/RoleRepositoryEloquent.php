<?php

namespace App\Repositories;

use App\Models\Role;


/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
