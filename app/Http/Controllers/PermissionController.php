<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PermissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $user_id = $user->id;
        
        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        $permission = Permission::get();
        return view('permission', [
            'permissions' => $permission,
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
        return view('createpermission', [
            'user' => $user,
            'rolename' => $roleName
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        //dd($validatedData);
        Permission::create($validatedData);
        return redirect()->route('permission.create')
            ->with('success', 'Permission created successfully.');
    }
    public function edit(Permission $id)
    {
        $user = Auth::user();

        $user_id = $user->id;
        
        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        return view('editpermission', [
            'permission' => $id,
            'user' => $user,
            'rolename' => $roleName
        ]);
    }
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        $permission = Permission::findOrFail($id);
        $permission->update($validatedData);

        return redirect()->route('permission.display')
            ->with('success', 'Permission updated successfully.');
    }
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permission.display')
            ->with('success', 'Permission deleted successfully.');
    }
}
