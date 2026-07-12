<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PostEditScreen extends Screen
{
    /**
     * Property for storing the current post model.
     */
    public ?Post $post = null;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Post $post): iterable
    {
        return [
            'post' => $post,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->post->exists ? 'Edit post' : 'Create post';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Save')
                ->icon('bs.plus-circle')
                ->method('createOrUpdate'),

            Button::make('Delete')
                ->icon('bs.trash')
                ->method('remove')
                ->canSee($this->post->exists), // The "Delete" button is visible only during editing.
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
            Layout::rows([
                Input::make('post.title')
                    ->title('Title')
                    ->placeholder('Enter the post title')
                    ->required(),

                TextArea::make('post.text')
                    ->title('Description')
                    ->rows(5)
                    ->placeholder('Write the post text here...')
                    ->required(),

                Relation::make('post.user_id')
                    ->title('Author')
                    ->fromModel(User::class, 'name') // Dropdown list of all system users
                    ->required(),
            ]),
        ];
    }

    /**
     * A method for creating or updating a post.
     */
    public function createOrUpdate(Post $post, Request $request)
    {
        $request->validate([
            'post.title'   => 'required|string|max:255',
            'post.text' => 'required|string',
            'post.user_id' => 'required|exists:users,id',
        ]);

        $model = $post->exists ? $post : new Post();
        $model->fill($request->get('post'))->save();

        Toast::info('The post has been successfully saved.');

        return redirect()->route('platform.posts');
    }

    /**
     * Method for deleting a post.
     */
    public function remove(Post $post)
    {
        $post->delete();

        Toast::info('Post successfully deleted.');

        return redirect()->route('platform.posts');
    }
}
