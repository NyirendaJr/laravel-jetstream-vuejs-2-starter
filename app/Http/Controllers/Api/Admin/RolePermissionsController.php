<?php

namespace App\Http\Controllers\Api\Admin;

use App\Data\Acl;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission\Permission;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionsController extends Controller
{
    public function __construct
    (
        public RoleRepository $rolesRepository,
        public PermissionRepository $permissionsRepository
    )
    {
        $this->middleware('permission:'.Acl::PERMISSION_UPDATE_ROLE_PERMISSION, ['only' => ['update']]);
        $this->middleware('permission:'.Acl::PERMISSION_DELETE_ROLE_PERMISSION, ['only' => ['destroy']]);
        $this->middleware('permission:'.Acl::PERMISSION_VIEW_ROLE_PERMISSION, ['only' => ['index']]);
    }


    /**
     * Get permissions from role
     *
     * @param int $roleId
     * @return mixed
     */
    public function index(int $roleId): mixed
    {
        return $this->rolesRepository->find($roleId)->permissions->map(function ($permission) {
            return new PermissionResource($permission);
        });
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $roleId
     * @return JsonResponse
     */
    public function update(Request $request, $roleId): JsonResponse
    {

        $role = $this->rolesRepository->find($roleId);

        if ($role->isSuperuser()) {
            return response()->json([
                'status' => false,
                'error' => 'Role not found',
                'statusCode' => Response::HTTP_NOT_FOUND
            ]);
        }

        $permissionIds = $request->get('permissions', []);
        $permissions = Permission::allowed()->whereIn('id', $permissionIds)->get();
        $role->permissions()->syncWithoutDetaching($permissions);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return response()
            ->json([
                'status' => true,
                Response::HTTP_OK
            ]);
    }

    public function destroy(int $permissionId, int $roleId): JsonResponse
    {
        $this->rolesRepository->find($roleId)->revokePermissionTo(
            $this->permissionsRepository->find($permissionId)
        );

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return response()
            ->json([
                'status' => true,
                'statusCode' => Response::HTTP_ACCEPTED
            ]);
    }
}
