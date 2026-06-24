<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    // Display a listing of the roles
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }
    // Show the form for creating a new role
    public function create()
    {
        return view('admin.roles.create');
    }

    // Store a newly created role in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    // Show the form for editing the specified role
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    // Update the specified role in storage
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|max:255',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    // Remove the specified role from storage
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
