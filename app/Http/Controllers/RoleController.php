<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $user_id = $user->id;
        
        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        $roles = Role::get();
        return view('roles', [
            'roles' => $roles,
            'user' => $user,
            'rolename' => $roleName
        ]);
    }
    public function create()
    {
        $user = Auth::user();

        $user_id = $user->id;
        
        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        return view('createrole', [
            'user' => $user,
            'rolename' => $roleName
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        Role::create($validatedData);
        return redirect()->route('role.create')
            ->with('success', 'Role created successfully.');
    }
    public function edit(Role $id)
    {
        $user = Auth::user();

        $user_id = $user->id;
        
        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        $roles = Role::get();
        return view('editrole', [
            'role' => $id,
            'user' => $user,
            'rolename' => $roleName
        ]);
    }
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $role = Role::findOrFail($id);
        $role->update($validatedData);

        return redirect()->route('role.display')
            ->with('success', 'Role updated successfully.');
    }
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.display')
            ->with('success', 'Role deleted successfully.');
    }
}
