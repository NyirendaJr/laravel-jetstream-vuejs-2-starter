<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use App\Http\Requests\CreateRoleFormRequest;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function __construct(
        public RoleRepository $rolesRepository
    ){}

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $params = [
            'paginate' => Arr::get($request, 'paginate', ''),
            'is_superuser' => true
        ];

        return RoleResource::collection($this->rolesRepository->get($params));
    }

    /**
     * CompanyStore a newly created resource in storage.
     *
     * @param CreateRoleFormRequest $request
     * @return JsonResponse
     */
    public function store(CreateRoleFormRequest $request): JsonResponse
    {
        $this->rolesRepository->create($request->validated());

        return response()
            ->json([
            'status' => true,
            'message' => 'Role created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
