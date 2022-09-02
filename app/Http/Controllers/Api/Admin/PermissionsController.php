<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Resources\PermissionResource;
use App\Repositories\PermissionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class PermissionsController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class PermissionsController extends Controller
{

    /**
     * PermissionsController constructor.
     *
     * @param PermissionRepository $repository
     */
    public function __construct(
        public PermissionRepository $repository
    ){}

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return PermissionResource::collection($this->repository->get($request->all()));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PermissionUpdateRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(PermissionUpdateRequest $request, int $id): JsonResponse
    {
        $this->repository->update($id, $request->validated());

        return response()
            ->json([
                'status' => true,
                'statusCode' => Response::HTTP_OK
            ]);
    }

}
