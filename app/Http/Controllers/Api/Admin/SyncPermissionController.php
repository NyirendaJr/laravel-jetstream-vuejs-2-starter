<?php

namespace App\Http\Controllers\Api\Admin;

use App\Data\Acl;
use App\Http\Controllers\Controller;
use App\Models\Permission\Permission;
use App\Models\Role\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SyncPermissionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $class = new \ReflectionClass(Acl::class);
            $constants = $class->getConstants();
            $permissions = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'PERMISSION_');
            });

            $permissionsArray = array_values($permissions);

            foreach ($permissionsArray as $perms) {
                Permission::firstOrcreate([
                    'name' => $perms,
                    'guard_name' => 'sanctum'
                ]);
            }

            // attach all permissions to the admin roles
            $superuserRole = Role::findByName(Acl::ROLE_SUPERUSER);
            $permissions = Permission::query()->where('guard_name', 'sanctum')->get();
            $superuserRole->syncPermissions($permissions);

            return response()
                ->json([
                    'status' => true,
                    'statusCode' => Response::HTTP_ACCEPTED
                ]);

        } catch (\ReflectionException $exception) {
            return [];
        }
    }
}
