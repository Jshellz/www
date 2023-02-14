<?php

namespace App\Orchid\Layouts;

use App\Models\Post;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PostListLayout extends Table
{
    public $target = 'posts';

    /**
     * Table list layout
     *
     * @return iterable
     */
    protected function columns(): iterable
    {
        return [
            TD::make('title')
            ->sort()
            ->filter(Input::make())
            ->render(function (Post $post) {
                return Link::make($post->title)
                    ->route('platform.list.post', $post);
            }),

            TD::make('create_at', 'Created')
            ->sort(),
            TD::make('update_at', 'Last edit')
            ->sort(),
        ];
    }
}
