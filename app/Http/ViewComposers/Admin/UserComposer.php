<?php

namespace App\Http\ViewComposers\Admin;

use App\Models\Role;
use Illuminate\Contracts\View\View;

class UserComposer
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
            '_userRoles' => Role::whereGuard('user')->get(),
            '_activeRoute' => 'admin.users_index',
            '_breadcrumb' => [
                [
                    'label' => 'Người dùng',
                    'route' => route('admin.users_index'),
                ],
            ],
        ]);
    }
}
