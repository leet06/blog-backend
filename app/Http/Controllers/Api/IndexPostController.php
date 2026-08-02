<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\GetPostsRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IndexPostController extends Controller
{
    public function __construct(
        protected RegisterService $registerService,
    ) {}    

    public function index(GetPostsRequest $request, PostService $postService): JsonResponse
    {
        $params = $request->validated();

        // Call the universal method (without passing the user).
        $posts = $postService->getFilteredList($params);

        return response()->json([
            'posts' => $posts,
            'count' => count($posts),
        ], Response::HTTP_OK);
    }
}
