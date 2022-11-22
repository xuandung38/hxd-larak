<?php

namespace App\Http\ViewComposers\Admin;

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
            '_activeRoute' => 'admin.profile',
            '_breadcrumb' => [
                [
                    'label' => 'Trang cá nhân',
                    'route' => route('admin.profile'),
                ],
            ],
        ]);
    }
}
