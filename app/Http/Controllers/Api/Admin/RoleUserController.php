<?php

namespace App\Http\Controllers\Api\Admin;

use App\Data\Acl;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\UserRepository;

class RoleUserController extends Controller
{
    public function __construct
    (
        public UserRepository $userRepository
    )
    {
        $this->middleware('permission:'.Acl::PERMISSION_CREATE_USER_ROLE, ['only' => ['store']]);
        $this->middleware('permission:'.Acl::PERMISSION_DELETE_USER_ROLE, ['only' => ['destroy']]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        $this->userRepository->find($request['user_id'])->roles()
            ->syncWithoutDetaching($request['selectedRoles']);

        activity()
            ->event('assign role to user')
            ->useLog('user')
            ->log('You have assign role to user');

        return response()
            ->json([
                'status' => true,
                'statusCode' => Response::HTTP_OK
            ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $user_id
     * @param int $role_id
     * @return JsonResponse
     */
    public function destroy(int $user_id, int $role_id): JsonResponse
    {

        $this->userRepository->find($user_id)->removeRole($role_id);

        activity()
            ->event('Revoke role from the user')
            ->useLog('user')
            ->log('You have remove role to user');

        return response()
            ->json([
                'status' => true,
                'statusCode' => Response::HTTP_OK
            ]);
    }
}
