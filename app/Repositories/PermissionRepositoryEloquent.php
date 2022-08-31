<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PermissionRepository;
use App\Models\Permission;
use App\Validators\PermissionValidator;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Presenters\PermissionPresenter;

/**
 * Class PermissionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Permission::class;
    }

    /**
    * Specify Validator class name
    *
    * @return string
     */
    public function validator(): string
    {

        return PermissionValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function presenter(): string
    {
        return PermissionPresenter::class;
    }

}
