<?php

namespace App\Http\ViewComposers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\View\View;

class RoleComposer
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
            '_roles' => Role::with('permissions')->get(),
            '_permissions' => Permission::all(),
            '_activeRoute' => 'admin.roles_index',
            '_breadcrumb' => [
                [
                    'label' => 'Phân quyền',
                    'route' => route('admin.roles_index'),
                ],
            ],
        ]);
    }
}
