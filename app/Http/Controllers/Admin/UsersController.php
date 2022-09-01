<?php

namespace App\Http\Controllers\Admin;

use App\Data\Acl;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use App\Http\Requests\UpdateUserFormRequest;
use App\Http\Requests\CreateUserFormRequest;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class UsersController extends Controller
{
    public function __construct(
        public UserRepository $repository
    ){}

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Admin/Users/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show(int $id): \Inertia\Response
    {
        $userData = new UserResource($this->repository->find($id));

        return Inertia::render('Admin/Users/Show', compact('userData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
