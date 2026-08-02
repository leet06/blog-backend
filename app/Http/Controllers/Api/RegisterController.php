<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __construct(
        protected RegisterService $registerService,
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $accessToken = $this->registerService->execute($validatedData);

        return response()->json([
            'accessToken' => $accessToken,
        ], Response::HTTP_CREATED);
    }
}
