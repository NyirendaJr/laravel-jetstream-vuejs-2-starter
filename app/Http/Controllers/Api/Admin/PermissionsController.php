<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Resources\PermissionResource;
use App\Repositories\PermissionRepository;
use App\Validators\PermissionValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
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
     * @param PermissionValidator $validator
     */
    public function __construct(
        public PermissionRepository $repository,
        public PermissionValidator $validator
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
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $this->repository->update($id, $request->all());

            return response()
                ->json([
                    'status' => true,
                    'statusCode' => Response::HTTP_OK
                ]);

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
