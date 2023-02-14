<?php

namespace App\Orchid\Screens;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PostEditScreen extends Screen
{
    public $post;

    /**
     * Query post
     *
     * @param Post $post
     * @return Post[]
     */
    public function query(Post $post): array
    {
        $post->load('attachment');

        return [
            'post' => $post
    ];
    }

    /**
     * Name page
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->post->exists ? 'Edit post' : 'Creating a new post';
    }

    /**
     * Description Page
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Blog post';
    }

    /**
     * Buttons bar
     *
     * @return array|\Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create post')
            ->icon('pencil')
            ->method('createOrUpdate')
            ->canSee(!$this->post->exists),

            Button::make('Update')
            ->icon('note')
            ->method('createOrUpdate')
            ->canSee($this->post->exists),

            Button::make('Remove')
            ->icon('trash')
            ->method('remove')
            ->canSee($this->post->exists),
        ];
    }


    /**
     * Layouts
     *
     * @return iterable
     * @throws BindingResolutionException
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('post.title')
                ->title('Title')
                ->placeholder('Attractive but mysterious title'),

            Cropper::make('post.hero')
                ->title('Large web banner image, generally in the front and center')
                ->width(1000)
                ->height(500)
                ->targetId(),

                TextArea::make('post.description')
                ->title('Description')
                ->rows(3)
                ->maxlength(200)
                ->placeholder('Brief description for preview'),

                Relation::make('post.author')
                ->title('Author')
                ->fromModel(User::class, 'name'),

                Quill::make('post.body')
                ->title('Main text'),
            ])
        ];
    }

    /**
     * Methods create or update post
     *
     * @param Post $post
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Post $post, Request $request): RedirectResponse
    {
        $post->fill($request->get('post'))->save();

        $post->attachment()->syncWithoutDetaching(
            $request->input('post.attachment', [])
        );

        Alert::info('You have successfully created a post.');

        return redirect()->route('platform,.post.list');

    }

    /**
     * Method delete post
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function remove(Post $post): RedirectResponse
    {
        $post->delete();

        Alert::info('You have successfully deleted the post.');

        return redirect()->route('platform.post.list');
    }
}
