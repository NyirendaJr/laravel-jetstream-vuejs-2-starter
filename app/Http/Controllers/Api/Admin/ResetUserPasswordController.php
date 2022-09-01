<?php

namespace App\Http\Controllers\Api\Admin;

use App\Data\Acl;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ResetUserPasswordController extends Controller
{
    public function __construct
    (
        public UserRepository $userRepository
    )
    {
        $this->middleware('permission:'.Acl::PERMISSION_RESET_USER_PASSWORD, ['only' => ['update']]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id): JsonResponse
    {

        $newPassword = Str::random(8);
        $email = $this->userRepository->find($id)->email;

        $this->userRepository->find($id)->update(['password' => bcrypt($newPassword)]);

        return response()
            ->json([
                'status' => true,
                'data' => [
                    'newPassword' => $newPassword,
                    'email' => $email
                ],
            ]);
    }
}
