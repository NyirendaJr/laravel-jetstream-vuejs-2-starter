<?php

namespace App\Http\Controllers\Api\Admin;

use App\Data\Acl;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockUserController extends Controller
{
    public function __construct
    (
        public UserRepository $userRepository
    )
    {
        $this->middleware('permission:'.Acl::PERMISSION_BLOCK_AND_UNBLOCK_USER, ['only' => ['update']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->userRepository->update($id, ['is_active' => $request['is_active']]);

        return response()
            ->json([
                'status' => true,
                'statusCode' => Response::HTTP_OK
            ]);
    }
}
