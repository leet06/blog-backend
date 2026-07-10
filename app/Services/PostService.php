<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function create(User $user, array $data): Post
    {
        // Create a post directly through the user
        return $user->posts()->create([
            'title' => $data['title'],
            'text' => $data['text'],
        ]);
    }

    private function formatPosts(Collection $posts): array
    {
        return $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'text' => $post->text,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at,
            ];
        })->toArray();
    }

    public function getFilteredList(array $params): array
    {
        $query = Post::query();

        // Filter by "from" date
        if (!empty($params['date_from']))
        {
            $query->whereDate('created_at', '>=', $params['date_from']);
        }

        // Filter by "before" date
        if (!empty($params['date_to']))
        {
            $query->whereDate('created_at', '<=', $params['date_to']);
        }

        // Dynamic sorting (newest at the top by default)
        $sortBy = $params['sort_by'] ?? 'created_at';
        $sortDirection = $params['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        // Chunking (pagination via limit/offset)
        $limit = $params['limit'] ?? 10;
        $offset = $params['offset'] ?? 0;

        $posts = $query->limit($limit)
            ->offset($offset)
            ->get();

        return $this->formatPosts($posts);
    }

    public function getUserFilteredList(\App\Models\User $user, array $params): array
    {
        // Selection of posts from a specific user only
        $query = $user->posts();

        // Filter by "from" date
        if (!empty($params['date_from']))
        {
            $query->whereDate('created_at', '>=', $params['date_from']);
        }

        // Filter by "to" date
        if (!empty($params['date_to']))
        {
            $query->whereDate('created_at', '<=', $params['date_to']);
        }

        // Sort
        $sortBy = $params['sort_by'] ?? 'created_at';
        $sortDirection = $params['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $limit = $params['limit'] ?? 10;
        $offset = $params['offset'] ?? 0;

        $posts = $query->limit($limit)
            ->offset($offset)
            ->get();

        return $this->formatPosts($posts);
    }
}
