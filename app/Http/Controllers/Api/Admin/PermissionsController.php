<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Response;
use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Repositories\PermissionRepository;
use App\Validators\PermissionValidator;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

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
     * @param PermissionValidator $validator
     */
    public function __construct(
        public PermissionRepository $repository,
        public PermissionValidator $validator
    ){}

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function index(): JsonResponse
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $permissions = $this->repository->paginate();

        return response()->json([
            'data' => $permissions,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $permission,
            ]);
        }

        return view('permissions.show', compact('permission'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PermissionUpdateRequest $request
     * @param  int  $id
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function update(PermissionUpdateRequest $request, int $id): JsonResponse
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $permission = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Permission updated.',
                'data'    => $permission->toArray(),
            ];

            return response()->json($response);

        } catch (ValidatorException $e) {

            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Permission deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Permission deleted.');
    }
}
