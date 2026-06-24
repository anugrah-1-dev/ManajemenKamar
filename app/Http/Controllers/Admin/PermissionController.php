<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;



class PermissionController extends Controller
{
    // Display a listing of the permissions
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    // Show the form for creating a new permission
    public function create()
    {
        return view('admin.permissions.create');
    }

    // Store a newly created permission in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name|max:255',
            'guard_name' => 'required|string',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    // Show the form for editing the specified permission
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    // Update the specified permission in storage
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id . '|max:255',
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    // Remove the specified permission from storage
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
