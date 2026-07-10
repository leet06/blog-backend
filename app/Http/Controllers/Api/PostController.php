<?php

namespace App\Http\Controllers\Api;

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

        $post = $postService->create($user, $validatedData);

        return response()->json([
            'accessToken' => $request->bearerToken(), // return current token
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'text' => $post->text,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at,
            ],
        ], 201);
    }
}
