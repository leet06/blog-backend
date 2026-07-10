<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\StorePostRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __invoke(StorePostRequest $request, PostService $postService): JsonResponse
    {
        $validatedData = $request->validated();

        // Laravel automatically finds the user with Bearer token
        $user = $request->user();

        $postData = $postService->create($user, $validatedData);

        return response()->json([
            'accessToken' => $request->bearerToken(), // return current token
            'post' => $postData
        ], 201);
    }
}
