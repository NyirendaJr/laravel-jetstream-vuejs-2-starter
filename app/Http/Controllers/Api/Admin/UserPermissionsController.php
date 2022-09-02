<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserPermissionsController extends Controller
{
    public function __construct(
        public UserRepository $userRepository
    ){}

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $permissions = Arr::get($request, 'selectedPermissions', []);
        $user = $this->userRepository->find($id);
        $user->givePermissionTo($permissions);

        activity()
            ->event('assign permission to user')
            ->performedOn($user)
            ->useLog('permission')
            ->log('You have updated user permissions');

        return response()
            ->json([
                'status' => true,
                'message' => 'User permissions updated successfully.'
            ]);
    }

    public function destroy($userId, $permissionId): \Illuminate\Http\JsonResponse
    {
        $user = $this->userRepository->find($userId);
        $user->revokePermissionTo($permissionId);

        activity()
            ->event('revoke permission to user')
            ->performedOn($user)
            ->useLog('permission')
            ->log('You have revoked permission');

        return response()
            ->json([
                'status' => true,
                'message' => 'User permissions updated successfully.'
            ]);
    }

}
