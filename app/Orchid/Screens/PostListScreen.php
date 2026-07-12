<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Post;
use App\Orchid\Layouts\PostListLayout;
use Orchid\Screen\Actions\Link;

class PostListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            // Retrieve posts, eager-loading the 'user' relationship to avoid N+1 queries
            'posts' => Post::with('user')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        // return 'PostListScreen';
        return 'Posts';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Create post')
                ->icon('bs.plus-circle')
                ->route('platform.posts.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            PostListLayout::class,
        ];
    }
}
