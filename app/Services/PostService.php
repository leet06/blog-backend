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
    }
}