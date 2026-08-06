<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\StorePostRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function store(StorePostRequest $request, PostService $postService): JsonResponse
    {
        $validatedData = $request->validated();

        // Laravel automatically finds the user with Bearer token
        $user = $request->user();

        $post = $postService->create($user, $validatedData);

        return response()->json([
            'accessToken' => $request->bearerToken(), // return current token
            'post' => new PostResource($post),
        ], Response::HTTP_CREATED);
    }
}
