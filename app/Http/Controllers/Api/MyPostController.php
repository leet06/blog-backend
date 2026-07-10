<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\GetPostsRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class MyPostController extends Controller
{
    public function __invoke(GetPostsRequest $request, PostService $postService): JsonResponse
    {
        // Validation of input parameters (limit, offset, sorting, dates)
        $params = $request->validated();
        
        // Current authorized user
        $user = $request->user();

        // Get an array from the class
        $posts = $postService->getUserFilteredList($params, $user);

        return response()->json([
            'posts' => $posts,
            'count' => count($posts),
        ]);
    }
}
