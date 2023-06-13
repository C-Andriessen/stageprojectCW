<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $roles = Role::where('name', '!=', 'GEBRUIKER')->where('name', '!=', 'ADMIN')->paginate(15);
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.role.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $role = new Role;
        $role->name = strtoupper($request->name);
        $role->save();
        return redirect(route('admin.role.index'))->with('status', __("Rol is toegevoegd"));
    }
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->name = strtoupper($request->name);
        $role->save();
        return redirect(route('admin.role.index'))->with('status', __("Rol is bijgewerkt"));
    }

    public function delete(Role $role)
    {
        $this->authorize('isAdmin', User::class);
        $role->delete();
        return redirect(route('admin.role.index'))->with('status', __('Rol "' . $role->name . '" is verwijderd'));
    }
}
