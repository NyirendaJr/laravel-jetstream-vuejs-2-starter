<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RolePermissionsController extends Controller
{

    public function __construct(
        public RoleRepository $repository
    ){}

    /**
     * Get permissions from role
     *
     * @param int $roleId
     * @return mixed
     */
    public function index(int $roleId): mixed
    {
        return $this->repository->find($roleId)->permissions->map(function ($permission) {
            return $permission->presenter();
        });
    }
}
