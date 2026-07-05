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
        // Получаем проверенные email и password
        $validatedData = $request->validated();

        // Вызываем и потом проверка и генерация токена
        $accessToken = $loginService->execute($validatedData);

        // Возвращаем JSON
        return response()->json([
            'accessToken' => $accessToken,
        ]);
    }
}
