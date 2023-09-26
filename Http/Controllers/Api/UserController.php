<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\Admin\CreateUserRequest;
use Modules\Auth\Http\Requests\UpdateUserRequest;
use Modules\Auth\Services\UserService;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
        return $this->userService->getAll();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->create(
            $request->toModel(),
            $request->role()
        );

        return response()
            ->json($user);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        return response()
            ->json($this->userService->getById($id));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $this->userService->update(
            $request->toModel(),
            $request->role()
        );

        return response()
            ->json($user);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        if (!$this->userService->delete($id)) {
            throw new HttpException(500, 'Could not delete user');
        }
        return response(201);
    }
}
