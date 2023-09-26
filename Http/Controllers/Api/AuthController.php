<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Services\AuthService;

class AuthController extends Controller {

    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request) {
        $token = $this->authService->authenticate(
            $request->validated('username'),
            $request->validated('password')
        );

        return response()
            ->json($token);
    }

    public function getCurrentUser() {
        $user = $this->authService->getCurrentUser();

        return response()
            ->json($user);
    }
}
