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

    public function getFilteredList(array $params): Collection
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

        return $query->limit($limit)
            ->offset($offset)
            ->get();
    }
}