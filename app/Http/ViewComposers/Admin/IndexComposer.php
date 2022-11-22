<?php

namespace App\Http\ViewComposers\Admin;

use App\Models\Role;
use Illuminate\Contracts\View\View;

class IndexComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $adminRoles = Role::whereGuard('admin')->get();

        $view->with([
            '_admin' => admin(),
            '_availableRoles' => admin_available_roles(admin(), $adminRoles),
            '_adminRoles' => $adminRoles,
            '_notifications' => [],
        ]);
    }
}
