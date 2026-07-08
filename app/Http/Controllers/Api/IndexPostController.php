<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\GetPostsRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class IndexPostController extends Controller
{
    public function __invoke(GetPostsRequest $request, PostService $postService): JsonResponse
    {
        $params = $request->validated();

        $posts = $postService->getFilteredList($params);

        // Serialize the list of publications into an array with the required structure.
        $responseData = $posts->map(function ($post)
        {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'text' => $post->text,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at,
            ];
        });

        return response()->json([
            'posts' => $responseData,
            'count' => $posts->count(),
        ]);
    }
}
