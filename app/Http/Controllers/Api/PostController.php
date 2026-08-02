<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\StorePostRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(
        protected RegisterService $registerService,
    ) {}

    public function store(StorePostRequest $request, PostService $postService): JsonResponse
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
        ], Response::HTTP_CREATED);
    }
}
