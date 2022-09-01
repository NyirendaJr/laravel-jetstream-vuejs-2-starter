<?php

namespace App\Http\Controllers\Api\Admin;

use App\Data\Acl;
use App\Http\Requests\CreateUserFormRequest;
use App\Http\Requests\UpdateUserFormRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class UsersController extends Controller
{
    public function __construct
    (
        public UserRepository $repository,
        public UserValidator $validator
    )
    {
        $this->middleware('permission:'.Acl::PERMISSION_CREATE_USER, ['only' => ['store']]);
        //$this->middleware('permission:'.Acl::PERMISSION_UPDATE_USER, ['only' => ['update']]);
        $this->middleware('permission:'.Acl::PERMISSION_DELETE_USER, ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $params = [
            'paginate' => Arr::get($request, 'paginate', 10),
            'per_page' => Arr::get($request, 'per_page', 10),
            'keyword' => Arr::get($request, 'keyword', ''),
            'is_superuser' => true
        ];

        return UserResource::collection($this->repository->get($params));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserFormRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserFormRequest $request): JsonResponse
    {
        $this->repository->create($request->validated());

        return response()
            ->json([
                'status' => true,
                'statusCode' => Response::HTTP_OK
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserFormRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserFormRequest $request, int $id): JsonResponse
    {
        $this->repository->update($id, $request->validated());

        return response()
            ->json([
                'status' => true,
                'message' => "User update successfully"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
