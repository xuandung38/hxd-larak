<?php

namespace App\Http\ViewComposers\Frontend;

use Illuminate\Contracts\View\View;

class ProfileComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            '_activeRoute' => 'index',
            '_groupRoute' => '',
            '_breadcrumb' => [
                [
                    'label' => 'Profile',
                    'route' => route('index'),
                ],
            ],
        ]);
    }
}
