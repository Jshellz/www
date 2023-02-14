<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, Attachable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'body',
        'author',
        'hero'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array|string[]
     */
    protected array $allowedSorts = [
        'title',
        'create_at',
        'update_at',
    ];

    /**
     * Name of columns to which http filter can be applied
     *
     * @var array|string[]
     */
    protected array $allowedFilters = [
        'title',
    ];

}
