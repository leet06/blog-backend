<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class PostService
{
    public function create(User $user, array $data): Post
    {
        // Create a post directly through the user
        return $user->posts()->create([
            'title' => $data['title'],
            'text' => $data['text'],
        ]);

        // The logic for data submission and processing
        return [
            'id' => $post->id,
            'title' => $post->title,
            'text' => $post->text,
            'user_id' => $post->user_id,
            'created_at' => $post->created_at,
        ];
    }
    
    public function getFilteredList(array $params): Collection
    {
        $query = Post::query();

        if (!empty($params['date_from']))
        {
            $query->whereDate('created_at', '>=', $params['date_from']);
        }

        if (!empty($params['date_to']))
        {
            $query->whereDate('created_at', '<=', $params['date_to']);
        }

        $sortBy = $params['sort_by'] ?? 'created_at';
        $sortDirection = $params['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $limit = $params['limit'] ?? 10;
        $offset = $params['offset'] ?? 0;

        return $query->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function getUserFilteredList(\App\Models\User $user, array $params): array
    {
        $query = $user->posts();

        if (!empty($params['date_from']))
        {
            $query->whereDate('created_at', '>=', $params['date_from']);
        }

        if (!empty($params['date_to']))
        {
            $query->whereDate('created_at', '<=', $params['date_to']);
        }

        $sortBy = $params['sort_by'] ?? 'created_at';
        $sortDirection = $params['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $limit = $params['limit'] ?? 10;
        $offset = $params['offset'] ?? 0;

        $posts = $query->limit($limit)
            ->offset($offset)
            ->get();

        return $posts->map(function ($post)
        {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'text' => $post->text,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at,
            ];
        })->toArray();
    }
}