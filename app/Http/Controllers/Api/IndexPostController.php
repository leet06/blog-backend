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

        return response()->json([
            'posts' => $posts,
            'count' => count($posts),
        ]);
    }
}
