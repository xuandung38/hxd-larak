<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\Contracts\View\View;

class AdminComposer
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
            '_activeRoute' => 'admin.admins_index',
            '_breadcrumb' => [
                [
                    'label' => 'Quản trị viên',
                    'route' => route('admin.admins_index'),
                ],
            ],
        ]);
    }
}
