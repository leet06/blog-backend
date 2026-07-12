<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Post;
use Orchid\Screen\Actions\Link;
use Illuminate\Support\Str;

class PostListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'posts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->sort(),

            TD::make('title', 'Title')
                ->sort()
                ->render(function (Post $post) {
                    // Make the title a link to edit the post
                    return Link::make($post->title)
                        ->route('platform.posts.edit', $post);
                }),

            TD::make('text', 'Text')
                ->render(function (Post $post) {
                    return Str::limit($post->text, 50);
                }),    

            TD::make('user_id', 'Author')
                ->render(function (Post $post) {
                    // Display the author's name if the relationship exists
                    return $post->user?->name ?? 'Unknown';
                }),

            TD::make('created_at', 'Post date')
                ->sort()
                ->render(function (Post $post) {
                    return $post->created_at->toDateTimeString();
                }),
        ];
    }
}
