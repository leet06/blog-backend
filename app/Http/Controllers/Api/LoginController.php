<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\LoginRequest;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginService $loginService): JsonResponse
    {
        // Obtain the verified email and password.
        $validatedData = $request->validated();

        // We make the call, followed by validation and token generation.
        $accessToken = $loginService->execute($validatedData);

        // return JSON
        return response()->json([
            'accessToken' => $accessToken,
        ]);
    }
}
