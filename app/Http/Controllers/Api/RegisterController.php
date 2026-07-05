<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, RegisterService $registerService): JsonResponse
    {
        $validatedData = $request->validated();

        $accessToken = $registerService->execute($validatedData);

        return response()->json([
            'accessToken' => $accessToken,
        ], 201);
    }
}
