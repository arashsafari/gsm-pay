<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;
use Exception;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(private readonly LoginService $loginService)
    {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->loginService->login($request->input('mobile'), $request->input('password'));
        } catch (Exception $exception) {

            return $this->error($exception->getMessage(), 401);
        }

        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
