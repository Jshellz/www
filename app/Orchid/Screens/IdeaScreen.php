<?php

namespace App\Orchid\Screens;

use App\Models\Order;
use Orchid\Screen\Screen;

class IdeaScreen extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'Idea Screen';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Idea Screen';

    /**
     * Query date
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'name' => 'Jone'
        ];
    }

    /**
     * Button commands
     *
     * @return array|\Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views
     *
     * @return iterable
     */
    public function layout(): iterable
    {
        return [
            'order' => Order::find(1),
            'orders' => Order::paginate(),
        ];
    }

}
